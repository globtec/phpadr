<?php

namespace ADR\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use org\bovigo\vfs\vfsStream;

class MakeDecisionCommandTest extends TestCase
{
    private $command;

    public function setUp()
    {
        $this->command = new MakeDecisionCommand();
    }

    public function testInstanceOfCommand()
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }

    public function testName()
    {
        $this->assertEquals('make:decision', $this->command->getName());
    }

    public function testDescription()
    {
        $this->assertEquals('Creates a new ADR', $this->command->getDescription());
    }

    public function testHelp()
    {
        $this->assertEquals('This command allows you to create a new ADR', $this->command->getHelp());
    }
    
    public function testArguments()
    {
        $this->assertTrue($this->command->getDefinition()->hasArgument('title'));
        
        $this->assertCount(1, $this->command->getDefinition()->getArguments());
    }
    
    public function testArgumentTitle()
    {
        $argument = $this->command->getDefinition()->getArgument('title');
        
        $this->assertTrue($argument->isRequired());
        $this->assertEquals('The title of the ADR', $argument->getDescription());
        $this->assertNull($argument->getDefault());
    }
    
    public function testOptions()
    {
        $this->assertTrue($this->command->getDefinition()->hasOption('directory'));
        
        $this->assertCount(1, $this->command->getDefinition()->getOptions());
    }
    
    public function testOptionDirectory()
    {
        $option = $this->command->getDefinition()->getOption('directory');
        
        $this->assertNull($option->getShortcut());
        $this->assertTrue($option->isValueRequired());
        $this->assertEquals('Workspace that store the ADRs', $option->getDescription());
        $this->assertEquals('docs/arch', $option->getDefault());
    }
    
    public function testExecute()
    {
        $vfs = vfsStream::setup();
        
        (new Application())->add($this->command);
        
        $tester = new CommandTester($this->command);

        $tester->execute([
            'command'     => $this->command->getName(), 
            'title'       => 'Foo',
            '--directory' => $vfs->url(),
        ]);
        
        $this->assertRegexp('/ADR created successfully/', $tester->getDisplay());
    }
}