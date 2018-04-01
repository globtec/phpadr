<?php

namespace ADR\Filesystem;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;
use ADR\Domain\DecisionRecord;
use RuntimeException;

class WorkspaceTest extends TestCase
{
    public function testSetSuccessfully()
    {
        $directory = vfsStream::setup()->url() . '/docs/arch';
        
        $workspace = new Workspace($directory);
        
        $this->assertEquals($directory, $workspace->get());
        $this->assertDirectoryIsWritable($workspace->get());
    }
    
    public function testSetFailure()
    {
        $this->expectException(RuntimeException::class);
        
        new Workspace('/path/to/docs/arch');
    }
    
    public function testCount()
    {
        $vfs = vfsStream::setup();
        
        $workspace = new Workspace($vfs->url());

        $this->assertEquals(0, $workspace->count());
        
        $vfs->addChild(vfsStream::newFile('0001-foo.md'));
        $vfs->addChild(vfsStream::newFile('0002-bar.md'));
        $vfs->addChild(vfsStream::newFile('0003-baz-2.md'));
        
        $vfs->addChild(vfsStream::newFile('0004-snake_case.md'));
        $vfs->addChild(vfsStream::newFile('0005-UPPERCASE.md'));
        $vfs->addChild(vfsStream::newFile('0006-CamelCase.md'));
        $vfs->addChild(vfsStream::newFile('any-file.md'));
        $vfs->addChild(vfsStream::newDirectory('any-directory'));
        
        $this->assertEquals(3, $workspace->count());
    }
    
    public function testAdd()
    {
        $vfs = vfsStream::setup();
        
        $record = $this->getMockBuilder(DecisionRecord::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $record->expects($this->once())->method('filename')->willReturn('0001-foo.md');
        $record->expects($this->once())->method('output');
        
        $workspace = new Workspace($vfs->url());
        $workspace->add($record);
        
        $this->assertFileExists($vfs->url() . '/0001-foo.md');
    }
}