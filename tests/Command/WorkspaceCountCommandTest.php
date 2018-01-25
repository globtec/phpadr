<?php

namespace ADR\Command;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class WorkspaceCountCommandTest extends TestCase
{
    private $command;
    
    public function setUp()
    {
        $this->command = new WorkspaceCountCommand();
    }
    
    public function testInstanceOfCommand()
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }
    
    public function testName()
    {
        $this->assertEquals('workspace:count', $this->command->getName());
    }
    
    public function testDescription()
    {
        $this->assertEquals('Count the ADRs', $this->command->getDescription());
    }
    
    public function testHelp()
    {
        $this->assertEquals('This command allows you count the ADRs', $this->command->getHelp());
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
    
    public function testExecuteCountZero()
    {
        $vfs = vfsStream::setup();
        
        $input = [
            'command'     => $this->command->getName(),
            '--directory' => $vfs->url(),
        ];
        
        (new Application())->add($this->command);
        
        $tester = new CommandTester($this->command);
        $tester->execute($input);
        
        $this->assertRegexp('/0 ADRs/', $tester->getDisplay());
        
        $vfs->addChild(vfsStream::newFile('0001-foo.md'));
        $vfs->addChild(vfsStream::newFile('0002-bar.md'));
        
        $tester->execute($input);
        
        $this->assertRegexp('/2 ADRs/', $tester->getDisplay());
    }
}