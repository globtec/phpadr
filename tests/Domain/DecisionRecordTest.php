<?php

namespace ADR\Domain;

use PHPUnit\Framework\TestCase;

class DecisionRecordTest extends TestCase
{
    private $content;
    
    public function setUp()
    {
        $this->content = $this->getMockBuilder(DecisionContent::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testFilename()
    {
        $this->content->expects($this->once())->method('getId')->willReturn(1);
        $this->content->expects($this->once())->method('getTitle')->willReturn('Foo');
        
        $record = new DecisionRecord($this->content);
        
        $this->assertEquals('001-foo.md', $record->filename());
    }
    
    public function testOutput()
    {
        $this->content->expects($this->once())->method('getId')->willReturn(1);
        $this->content->expects($this->once())->method('getTitle')->willReturn('Foo');
        $this->content->expects($this->once())->method('getStatus')->willReturn('Accepted');
        
        $record = new DecisionRecord($this->content);
        
        $output = $record->output();
        
        $this->assertContains('# 1. Foo', $output);
        $this->assertContains(date('Y-m-d'), $output);
        $this->assertContains('Accepted', $output);
    }
}