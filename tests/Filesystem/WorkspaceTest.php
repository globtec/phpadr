<?php

namespace ADR\Filesystem;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use RuntimeException;
use ADR\Domain\DecisionRecord;

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
    
    public function testCount()
    {
        $vfs = vfsStream::setup();
        $vfs->addChild(vfsStream::newFile('001-foo.md'));
        $vfs->addChild(vfsStream::newFile('002-bar.md'));
        
        $workspace = new Workspace($vfs->url());
        
        $this->assertEquals(2, $workspace->count());
    }
    
    public function testAdd()
    {
        $vfs = vfsStream::setup();
        
        $record = $this->getMockBuilder(DecisionRecord::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $record->expects($this->once())->method('filename')->willReturn('001-foo.md');
        $record->expects($this->once())->method('output');
        
        $workspace = new Workspace($vfs->url());
        $workspace->add($record);
        
        $this->assertFileExists($vfs->url() . '/001-foo.md');
    }
}