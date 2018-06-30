<?php

namespace ADR\Filesystem;

use RuntimeException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testInstanceSuccessfully()
    {
        $config = new Config(__DIR__ . '/../../adr.yml');

        $this->assertEquals('docs/arch', $config->directory());
        $this->assertEquals('template/skeleton.md', $config->decisionRecordTemplateFile());
    }

    public function testInstanceFailure()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The config file does not exist: invalid.yml');

        new Config('invalid.yml');
    }
}