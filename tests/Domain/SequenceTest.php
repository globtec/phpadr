<?php

namespace ADR\Domain;

use PHPUnit\Framework\TestCase;
use ADR\Filesystem\Workspace;
use DomainException;

class SequenceTest extends TestCase
{
    private $workspace;
    
    public function setUp()
    {
        $this->workspace = $this->getMockBuilder(Workspace::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    public function testNextWithSuccessful()
    {
        $this->workspace->expects($this->once())->method('count')->willReturn(0);
        
        $sequence = new Sequence($this->workspace);
        
        $this->assertEquals(1, $sequence->next());
    }
    
    public function testNextWithFailure()
    {
        $this->expectException(DomainException::class);
        
        $this->workspace->expects($this->once())->method('count')->willReturn(999);
        
        $sequence = new Sequence($this->workspace);
        $sequence->next();
    }
}