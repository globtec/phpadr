<?php

namespace ADR\Filesystem;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use RuntimeException;

class WorkspaceTest extends TestCase
{
    public function testSetWithSuccess()
    {
        $directory = vfsStream::setup()->url() . '/docs/arch';
        
        $workspace = new Workspace($directory);
        
        $this->assertEquals($directory, $workspace->get());
        $this->assertDirectoryIsWritable($workspace->get());
    }
    
    public function testSetWithFailure()
    {
        $this->expectException(RuntimeException::class);
        
        new Workspace('/path/to/docs/arch');
    }
}