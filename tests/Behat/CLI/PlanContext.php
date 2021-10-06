<?php

namespace App\Tests\Behat\CLI;

use App\Domain\Plan;
use App\Domain\Repository\PlanById;
use App\UI\Cli\CreatePlan;
use Behat\Behat\Context\Context;
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
        private EntityManagerInterface $em,
        private PlanById $planById
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
        $this->args = [];
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
}
