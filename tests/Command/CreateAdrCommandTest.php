<?php

namespace ADR\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CreateAdrCommandTest extends TestCase
{
    private $command;

    public function setUp()
    {
        $this->command = new CreateAdrCommand();
    }

    public function testInstanceOfCommand()
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }

    public function testName()
    {
        $this->assertEquals('make:skeleton', $this->command->getName());
    }

    public function testDescription()
    {
        $this->assertEquals('Creates a new ADR file', $this->command->getDescription());
    }

    public function testHelp()
    {
        $this->assertEquals('This command allows you to create a new ADR file', $this->command->getHelp());
    }
    
    public function testExecute()
    {
        (new Application())->add($this->command);

        $tester = new CommandTester($this->command);
        $tester->execute(['command' => $this->command->getName(), 'title' => 'Foo']);

        $this->assertRegexp('/ADR file successfully generated/', $tester->getDisplay());
    }
}