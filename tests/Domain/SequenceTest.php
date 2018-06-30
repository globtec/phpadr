<?php

namespace ADR\Domain;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ADR\Filesystem\Workspace;
use LogicException;

class SequenceTest extends TestCase
{
    /**
     * @var Workspace|MockObject
     */
    private $workspace;
    
    public function setUp()
    {
        $this->workspace = $this->getMockBuilder(Workspace::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
    
    /**
     * @dataProvider providerTestNextSuccessfully
     */
    public function testNextSuccessfully($count, $expected)
    {
        $sequence = new Sequence($this->workspace);
        
        $this->workspace->expects($this->once())->method('count')->willReturn($count);
        
        $this->assertEquals($expected, $sequence->next());
    }
    
    public function testNextFailure()
    {
        $this->expectException(LogicException::class);
        
        $this->workspace->expects($this->once())->method('count')->willReturn(Sequence::MAX_VALUE);
        
        $sequence = new Sequence($this->workspace);
        $sequence->next();
    }
    
    public function providerTestNextSuccessfully()
    {
        return [
            [0, 1],
            [10, 11],
            [100, 101],
            [999, 1000],
            [1050, 1051],
        ];
    }
}