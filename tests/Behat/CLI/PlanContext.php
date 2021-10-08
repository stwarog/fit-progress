<?php

namespace App\Tests\Behat\CLI;

use App\Domain\Exercise;
use App\Domain\Plan;
use App\UI\Cli\CreatePlan;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

final class PlanContext implements Context
{
    private array $args = [];

    public function __construct(
        private CreatePlan $command,
        private EntityManagerInterface $em
    ) {
        $this->em->beginTransaction();
    }

    public function __destruct()
    {
        $this->em->rollback();
    }

    /**
     * @Given /^a plan named "([^"]*)"$/
     */
    public function aPlanNamed($name)
    {
        $this->args['name'] = $name;
    }

    /**
     * @When /^command app:plan:create is executed$/
     */
    public function commandAppPlanCreateIsExecuted()
    {
        $input = new ArrayInput($this->args);
        $output = new NullOutput();

        try {
            $this->command->run($input, $output);
        } catch (RuntimeException $e) {
        }
    }

    /**
     * @Then /^new plan should be created with name "([^"]*)"$/
     */
    public function newPlanShouldBeCreatedWithName($name)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(p.id)')
            ->where('p.name = :name')
            ->from(Plan::class, 'p');

        $qb->setParameter('name', $name);

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(1, $count);
    }

    /**
     * @Given /^a plan without name$/
     */
    public function aPlanWithoutName()
    {
        //
    }

    /**
     * @Then /^no plan should be created$/
     */
    public function noPlanShouldBeCreated()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('count(p.id)')
            ->from(Plan::class, 'p');

        $count = $qb->getQuery()->getSingleScalarResult();

        Assert::assertEquals(0, $count);
    }

    /**
     * @Given /^exercises are set to$/
     */
    public function exercisesAreSetTo(TableNode $table)
    {
        $data = [];

        foreach ($table as $item) {
            $data[] = implode(',', array_values($item));
        }

        $this->args['exercises'] = $data;
    }

    /**
     * @Given /^plan exercises should be added$/
     */
    public function planExercisesShouldBeAdded(TableNode $table)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('a.id, a.exerciseId, a.repeats, a.weight')
            ->from(Exercise::class, 'a')
            ->orderBy('a.weight');

        $actual = $qb->getQuery()->getResult();

        for ($c = 0; $c !== count($actual); $c++) {
            $a = array_slice($actual[$c], 1); # remove id
            $a = array_reverse($a); # match order with table
            $e = $table->getRow($c + 1); # ignore column names
            Assert::assertEquals(array_values($e), array_values($a));
        }
    }
}
