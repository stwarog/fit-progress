<?php

namespace App\Tests\Behat\CLI;

use App\Domain\Activity;
use App\Domain\Catalog\ExerciseId;
use App\Domain\Name;
use App\Domain\Repository\ExerciseById;
use App\Domain\Repository\PlanById;
use App\Domain\Repository\TrainingById;
use App\Domain\Repository\TrainingStore;
use App\Domain\Training;
use App\Domain\TrainingId;
use App\UI\Cli\AddActivity;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

final class AddTrainingActivityContext implements Context
{
    private array $args = [];

    public function __construct(
        private AddActivity $command,
        private TrainingById $trainingById,
        private ExerciseById $exerciseById,
        private EntityManagerInterface $em,
        private PlanById $planById,
        private TrainingStore $store
    ) {
        $this->em->beginTransaction();
    }

    public function __destruct()
    {
        $this->em->rollback();
    }

    /**
     * @Given /^there is an existing exercise "([^"]*)" in the catalog$/
     */
    public function thereIsAnExistingExerciseInTheCatalog($exercise)
    {
        Assert::assertNotEmpty($this->exerciseById->findOne(new ExerciseId($exercise)));
    }

    /**
     * @Given /^there is an existing training "([^"]*)"$/
     */
    public function thereIsAnExistingTraining($training)
    {
        $trainingId = new TrainingId($training);

        if (empty($this->trainingById->findOne($trainingId))) {
            $t = new Training(
                $trainingId,
                new Name('FBW'),
                $this->planById
            );
            $this->store->store($t);
        }
    }

    /**
     * @Given /^Activity with training "([^"]*)"$/
     */
    public function activityWithTraining($training)
    {
        $this->args['training'] = $training;
    }

    /**
     * @Given /^and Exercise "([^"]*)" from the catalog$/
     */
    public function andExerciseFromTheCatalog($exercise)
    {
        $this->args['exercise'] = $exercise;
    }

    /**
     * @Given /^weight "([^"]*)" is set$/
     */
    public function weightIsSet($weight)
    {
        $this->args['weight'] = $weight;
    }

    /**
     * @Given /^repeats "([^"]*)" are set$/
     */
    public function repeatsAreSet($repeats)
    {
        $this->args['repeats'] = $repeats;
    }

    /**
     * @Then /^new Activity should be added$/
     */
    public function newActivityShouldBeAdded(TableNode $table)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('a.id, a.trainingId, a.exerciseId, a.repeats, a.weight')
            ->where('a.trainingId = :training')
            ->from(Activity::class, 'a');

        $rows = $table->getRow(1);
        $expected = $rows;

        $qb->setParameter('training', $expected[0]);

        $actual = $qb->getQuery()->getSingleResult();
        $actual = array_values(array_slice($actual, 1));
        $expected = array_values($expected);

        Assert::assertEquals($expected[0], $actual[0]);
        Assert::assertEquals($expected[1], $actual[3]);
        Assert::assertEquals($expected[2], $actual[2]);
        Assert::assertEquals($expected[3], $actual[1]);
    }

    /**
     * @When /^command app:add:activity is executed$/
     */
    public function commandAppAddActivityIsExecuted()
    {
        $input = new ArrayInput($this->args);
        $output = new NullOutput();

        try {
            $this->command->run($input, $output);
        } catch (RuntimeException $e) {
        }
    }
}
