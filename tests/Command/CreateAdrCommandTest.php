<?php

namespace ADR\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;

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
        $this->assertEquals('adr:create', $this->command->getName());
    }

    public function testDescription()
    {
        $this->assertEquals('Creates a new ADR file', $this->command->getDescription());
    }

    public function testHelp()
    {
        $this->assertEquals('This command allows you to create a new ADR file', $this->command->getHelp());
    }
}