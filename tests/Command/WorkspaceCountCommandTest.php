<?php

namespace ADR\Command;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class WorkspaceCountCommandTest extends TestCase
{
    /**
     * @var WorkspaceCountCommand
     */
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
        $this->assertTrue($this->command->getDefinition()->hasOption('config'));

        $this->assertCount(1, $this->command->getDefinition()->getOptions());
    }

    public function testOptionConfig()
    {
        $option = $this->command->getDefinition()->getOption('config');

        $this->assertNull($option->getShortcut());
        $this->assertTrue($option->isValueRequired());
        $this->assertEquals('Config file', $option->getDescription());
        $this->assertEquals('vendor/globtec/phpadr/adr.yml', $option->getDefault());
    }

    public function testExecute()
    {
        $vfs = vfsStream::setup();
        $configContent = file_get_contents('adr.yml');
        $configContent = str_replace('docs/arch', $vfs->url(), $configContent);
        $configFile = vfsStream::newFile('adr.yml')->at($vfs)->setContent($configContent)->url();

        $input = [
            'command'  => $this->command->getName(),
            '--config' => $configFile,
        ];

        (new Application())->add($this->command);

        $tester = new CommandTester($this->command);
        $tester->execute($input);

        $this->assertRegexp('/0/', $tester->getDisplay());

        $vfs->addChild(vfsStream::newFile('0001-foo.md'));
        $vfs->addChild(vfsStream::newFile('0002-bar.md'));

        $tester->execute($input);

        $this->assertRegexp('/2/', $tester->getDisplay());
    }
}