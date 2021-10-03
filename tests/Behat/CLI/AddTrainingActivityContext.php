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
use Exception;
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
//        $this->em->beginTransaction();
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
        $t = new Training(
            new TrainingId($training),
            new Name('FBW'),
            $this->planById
        );
        try {
            $this->store->store($t);
        } catch (Exception $e) {
        }
        Assert::assertNotNull($this->trainingById->findOne(new TrainingId($training)));
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
        $qb->select('count(a.id)')
            ->where('a.trainingId = :training')
            ->andWhere('a.exerciseId = :exercise')
            ->andWhere('a.weight = :weight')
            ->andWhere('a.repeats = :repeats')
            ->from(Activity::class, 'a');

        $columns = $table->getRow(0);
        $rows = $table->getRow(1);

        foreach (array_combine($columns, $rows) as $k => $v) {
            dump($k, $v);
            $qb->setParameter($k, $v);
        }

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(1, $count);;
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
