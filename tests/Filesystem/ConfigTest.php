<?php

namespace ADR\Filesystem;

use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ConfigTest extends TestCase
{
    public function testInstanceSuccessfully()
    {
        $config = new Config(__DIR__ . '/../../adr.yml');

        $this->assertEquals('docs/arch', $config->directory());
        $this->assertEquals('vendor/globtec/phpadr/template/skeleton.md', $config->decisionRecordTemplateFile());
    }

    public function testInstanceNotExistingFailure()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The config file does not exist: invalid.yml');

        new Config('invalid.yml');
    }

    public function testInstanceNotReadableFailure()
    {
        $vfs = vfsStream::setup();
        $configFile = vfsStream::newFile('adr.yml')->at($vfs)->chmod(0)->url();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("The config file isn't readable: $configFile");

        new Config($configFile);
    }
}