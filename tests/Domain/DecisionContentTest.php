<?php

namespace ADR\Domain;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class DecisionContentTest extends TestCase
{
    /**
     * @dataProvider providerTestInstanceWithSuccessful
     */
    public function testInstanceWithSuccessful($status)
    {
        $content = new DecisionContent(1, 'Foo', $status);
        
        $this->assertEquals(1, $content->getId());
        $this->assertEquals('Foo', $content->getTitle());
        $this->assertEquals($status, $content->getStatus());
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanceFailureWithTitle()
    {
        new DecisionContent(1, 'A very large title should not be used in arquitecture decision record because this attribute must be short noun phrases');
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanceFailureWithStatus()
    {
        new DecisionContent(1, 'Foo', 'Superseded');
    }
    
    public function providerTestInstanceWithSuccessful()
    {
        return [
            ['Proposed'],
            ['Accepted'],
            ['Rejected'],
            ['Deprecated'],
        ];
    }
    
}