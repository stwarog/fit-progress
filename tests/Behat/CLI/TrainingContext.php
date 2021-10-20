<?php

namespace App\Tests\Behat\CLI;

use App\Application\CreatePlan\Command as CreatePlanCommand;
use App\Domain\Training;
use App\Shared\Application\Command\CommandBus;
use App\UI\Cli\CreateTraining;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

final class TrainingContext implements Context
{
    private array $args = [];

    public function __construct(
        private CreateTraining $command,
        private EntityManagerInterface $em,
        private CommandBus $bus
    ) {
//        $this->em->beginTransaction();
    }

    public function __destruct()
    {
//        $this->em->rollback();
    }

    /**
     * @Given /^a Training named "([^"]*)"$/
     */
    public function aTraining($name)
    {
        $this->args['name'] = $name;
    }

    /**
     * @When /^command app:training:create is executed$/
     */
    public function aCommandIsExecuted()
    {
        $input = new ArrayInput($this->args);
        $output = new NullOutput();

        try {
            $this->command->run($input, $output);
        } catch (RuntimeException $e) {
        }
    }

    /**
     * @Then /^new Training should be created with name "([^"]*)" and current date$/
     */
    public function newTrainingShouldBeCreatedWithName($name)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(t.id)')
            ->where('t.name = :name')
            ->andWhere('t.date = :date')
            ->from(Training::class, 't');

        $qb->setParameter('name', $name);
        $qb->setParameter('date', date('Y-m-d'));

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(1, $count);
    }

    /**
     * @Given /^date "([^"]*)" is set$/
     */
    public function dateIsSet($date)
    {
        $this->args['date'] = $date;
    }

    /**
     * @Then /^new Training should be created with name "([^"]*)" and date should "([^"]*)"$/
     */
    public function newTrainingShouldBeCreatedWithNameAndDateShould($name, $date)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(t.id)')
            ->where('t.name = :name')
            ->andWhere('t.date = :date')
            ->from(Training::class, 't');

        $qb->setParameter('name', $name);
        $qb->setParameter('date', $date);

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(1, $count);
    }

    /**
     * @Given /^an existing Plan with id "([^"]*)"$/
     */
    public function anExistingPlanWithId($planId)
    {
        $command = new CreatePlanCommand('Plan', [], $planId);
        $this->bus->handle($command);
    }

    /**
     * @Given /^plan "([^"]*)" is set$/
     */
    public function planIsSet($planId)
    {
        $this->args['plan'] = $planId;
    }

    /**
     * @Then /^new Training should be created with name "([^"]*)" and date should "([^"]*)" and plan "([^"]*)"$/
     */
    public function newTrainingShouldBeCreatedWithNameAndDateShouldAndPlan($name, $date, $plan)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(t.id)')
            ->where('t.name = :name')
            ->andWhere('t.date = :date')
            ->andWhere('t.planId = :plan')
            ->from(Training::class, 't');

        $qb->setParameter('name', $name);
        $qb->setParameter('date', $date);
        $qb->setParameter('plan', $plan);

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(1, $count);
    }

    /**
     * @Given /^a Training without name$/
     */
    public function aTrainingWithoutName()
    {
        //
    }

    /**
     * @Then /^no training should be created$/
     */
    public function noTrainingShouldBeCreated()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(t.id)')
            ->from(Training::class, 't');

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(0, $count);
    }
}
