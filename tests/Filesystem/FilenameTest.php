<?php

namespace ADR\Filesystem;

use PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class FilenameTest extends TestCase
{
    private $workspace;
    
    public function setUp()
    {
        $this->workspace = $this->getMockBuilder(Workspace::class)->getMock();
        
        $this->filename = new Filename($this->workspace);
    }
    
    /**
     * @dataProvider providerTestGet
     */
    public function testGet(string $title, string $expected)
    {
        $this->workspace->expects($this->once())
            ->method('get')
            ->willReturn(vfsStream::setup()->url());
        
        $this->assertEquals($expected, $this->filename->get($title));
    }
    
    public function providerTestGet() : array
    {
        return [
            ['Something & Something', '0001-something-something.md'],
            ['Under_Score', '0001-under-score.md'],
            ['Don\'t', '0001-dont.md'],
            ['(parenthesis)', '0001-parenthesis.md'],
            ['"$" - dollar sign', '0001-dollar-sign.md'],
        ];
    }
        
    public function testGetWithSequence()
    {
        $root = vfsStream::setup();

        $this->workspace->expects($this->any())
            ->method('get')
            ->willReturn($root->url());
            
        $stack = [
            ['Example One', '0001-example-one.md'],
            ['Example Two', '0002-example-two.md'],
            ['Example Three', '0003-example-three.md'],
            ['Example Four', '0004-example-four.md'],
            ['Example Five', '0005-example-five.md'],
        ];
        
        foreach ($stack as $value) {
            list($title, $expected) = $value;
            
            $actual = $this->filename->get($title);
            
            $this->assertEquals($expected, $actual);
            
            $root->addChild(vfsStream::newFile($actual));
        }
    }
    
    public function testPathname()
    {
        $directory = vfsStream::setup()->url();
        
        $this->workspace->expects($this->any())
            ->method('get')
            ->willReturn($directory);
        
        $expected = $directory . DIRECTORY_SEPARATOR . '0001-foo.md';
            
        $this->assertEquals($expected, $this->filename->pathname('Foo'));
        
    }
}