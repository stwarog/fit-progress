<?php

namespace App\Tests\Behat\CLI;

use App\Training\Domain\Activity;
use App\Training\Domain\Catalog\ExerciseById;
use App\Training\Domain\Catalog\ExerciseId;
use App\Training\Domain\Name;
use App\Training\Domain\Repository\PlanById;
use App\Training\Domain\Repository\TrainingById;
use App\Training\Domain\Repository\TrainingStore;
use App\Training\Domain\Training;
use App\Training\Domain\TrainingId;
use App\Training\UI\Cli\AddActivity;
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
        $qb->select('a.id, a.exerciseId, a.repeats, a.weight, a.date')
            ->where('a.exerciseId = :exercise')
            ->from(Activity::class, 'a');

        $rows = $table->getRow(1);
        $expected = $rows;

        $qb->setParameter('exercise', $expected[2]);

        $actual = $qb->getQuery()->getSingleResult();
        [$e, $r, $w, $date] = array_values(array_slice($actual, 1));
        [$weight, $repeats, $exercise] = array_values($expected);

        Assert::assertEquals($weight, $w);
        Assert::assertEquals($repeats, $r);
        Assert::assertEquals($exercise, $e);
        Assert::assertNotEmpty($date);
    }

    /**
     * @When /^command app:activity:add is executed$/
     */
    public function commandAppAddActivityIsExecuted(?TableNode $node = null)
    {
        $args = $node ? array_combine(['training', 'weight', 'repeats', 'exercise'], $node->getRow(1)) : $this->args;
        $input = new ArrayInput($args);
        $output = new NullOutput();

        try {
            $this->command->run($input, $output);
        } catch (RuntimeException $e) {
            dump($args);
            dump($e->getMessage() . ' for ' . var_dump($args));
        }
    }

    /**
     * @Given /^an Activity without fields$/
     */
    public function anActivityWithoutFields()
    {
        $this->args = [];
    }

    /**
     * @Then /^no Activity should be created$/
     */
    public function noActivityShouldBeCreated()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(a.id)')
            ->from(Activity::class, 'a');

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(0, $count);
    }
}
