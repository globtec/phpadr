<?php

namespace ADR\Domain;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class DecisionContentTest extends TestCase
{
    /**
     * @dataProvider providerTestInstanceSuccessfully
     */
    public function testInstanceSuccessfully($input, $output)
    {
        $content = new DecisionContent(1, 'Foo', $input);

        $this->assertEquals(1, $content->getId());
        $this->assertEquals('Foo', $content->getTitle());
        $this->assertEquals($output, $content->getStatus());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanceFailureWithTitle()
    {
        new DecisionContent(1,
            'A very large title should not be used in arquitecture decision record because this attribute must be short noun phrases');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInstanceFailureWithStatus()
    {
        new DecisionContent(1, 'Foo', 'Superseded');
    }

    public function providerTestInstanceSuccessfully()
    {
        return [
            ['Proposed', 'Proposed'],
            ['proposed', 'Proposed'],
            ['Accepted', 'Accepted'],
            ['accepted', 'Accepted'],
            ['Rejected', 'Rejected'],
            ['rejected', 'Rejected'],
            ['Deprecated', 'Deprecated'],
            ['deprecated', 'Deprecated'],
        ];
    }

}