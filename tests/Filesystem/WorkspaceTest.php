<?php

namespace ADR\Filesystem;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class WorkspaceTest extends TestCase
{
    private $workspace;
    
    public function setUp()
    {
        $this->workspace = new Workspace();
    }
    
    public function testSetWithSuccess()
    {
        $directory = vfsStream::setup()->url();
        
        $this->workspace->set($directory);
        
        $this->assertEquals($directory, $this->workspace->get());
        $this->assertDirectoryIsWritable($this->workspace->get());
    }
    
    public function testSetWithFailure()
    {
        $this->expectException(\RuntimeException::class);
        
        $this->workspace->set('/path/to/docs/arch');
    }
}