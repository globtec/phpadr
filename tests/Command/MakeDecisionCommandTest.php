<?php

namespace ADR\Command;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class MakeDecisionCommandTest extends TestCase
{
    /**
     * @var MakeDecisionCommand
     */
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
        $this->assertTrue($this->command->getDefinition()->hasArgument('status'));

        $this->assertCount(2, $this->command->getDefinition()->getArguments());
    }

    public function testArgumentTitle()
    {
        $argument = $this->command->getDefinition()->getArgument('title');

        $this->assertTrue($argument->isRequired());
        $this->assertEquals('The title of the ADR', $argument->getDescription());
        $this->assertNull($argument->getDefault());
    }

    public function testArgumentStatus()
    {
        $argument = $this->command->getDefinition()->getArgument('status');

        $this->assertFalse($argument->isRequired());
        $this->assertEquals('The status of the ADR, available options: [Proposed, Accepted, Rejected, Deprecated]',
            $argument->getDescription());
        $this->assertEquals('Accepted', $argument->getDefault());
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
        $configContent = str_replace('vendor/globtec/phpadr/', '', $configContent);
        $configFile = vfsStream::newFile('adr.yml')->at($vfs)->setContent($configContent)->url();

        (new Application())->add($this->command);

        $tester = new CommandTester($this->command);

        $tester->execute([
            'command'  => $this->command->getName(),
            'title'    => 'Foo',
            '--config' => $configFile,
        ]);

        $this->assertRegexp('/ADR created successfully/', $tester->getDisplay());
    }
}