<?php

namespace App\Tests\Behat\CLI;

use App\Application\CommandBus;
use App\Application\CreatePlan\Command as CreatePlanCommand;
use App\Application\CreateTraining\Command as CreateTrainingCommand;
use App\Tests\Behat\Utils\TableFromOutput;
use App\UI\Cli\FindTrainings;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

use const PHP_EOL;

final class FindTrainingsContext implements Context
{
    private OutputInterface $output;

    public function __construct(
        private CommandBus $bus,
        private FindTrainings $command,
        private EntityManagerInterface $em
    ) {
        $this->em->beginTransaction();
        $this->output = new BufferedOutput();
    }

    public function __destruct()
    {
        $this->em->rollback();
    }

    /**
     * @Given /^predefined plans$/
     */
    public function predefinedPlans(TableNode $table)
    {
        foreach ($table as $data) {
            $name = $data['name'];
            $exercises = explode(' ', $data['exercises']);
            $exercises = array_map(fn(string $s) => explode(',', $s), $exercises);
            $id = $data['id'];
            $c = new CreatePlanCommand($name, $exercises, $id);
            $this->bus->handle($c);
        }
    }

    /**
     * @Given /^trainings that has been made$/
     */
    public function trainingsThatHasBeenMade(TableNode $table)
    {
        foreach ($table as $data) {
            $c = new CreateTrainingCommand(
                $data['name'],
                $data['date'],
                $data['plan'],
                $data['id'],
            );
            $this->bus->handle($c);
        }
    }

    /**
     * @Then /^a list with values should be displayed$/
     */
    public function aListWithValuesShouldBeDisplayed(PyStringNode $markdown)
    {
        $unify = fn(string $s) => str_replace([PHP_EOL, ' ', '+', '-'], ['', '', '', ''], $s);
        $expected = $markdown->getRaw() . PHP_EOL;
        $actual = $this->output->fetch();

        try {
            Assert::assertSame(
                $unify($expected),
                $unify($actual),
            );
        } catch (ExpectationFailedException $e) {
            dump($expected);
            dump($actual);
            throw new ExpectationFailedException('The expected output is invalid');
        }
    }

    /**
     * @When /^command app:training:list is executed$/
     */
    public function commandAppTrainingListIsExecuted()
    {
        $input = new ArrayInput([]);

        try {
            $this->command->run($input, $this->output);
        } catch (RuntimeException $e) {
        }
    }
}
