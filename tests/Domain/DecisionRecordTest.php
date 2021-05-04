<?php

namespace ADR\Domain;

use ADR\Filesystem\Config;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DecisionRecordTest extends TestCase
{
    /**
     * @var DecisionContent|MockObject
     */
    private $content;

    /**
     * @var Config|MockObject
     */
    private $config;

    public function setUp()
    {
        $this->content = $this->getMockBuilder(DecisionContent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testFilename()
    {
        $this->content->expects($this->once())->method('getId')->willReturn(1);
        $this->content->expects($this->once())->method('getTitle')->willReturn('Foo');

        $record = new DecisionRecord($this->content, $this->config);

        $this->assertEquals('0001-foo.md', $record->filename());
    }

    public function testOutput()
    {
        $this->content->expects($this->once())->method('getId')->willReturn(1);
        $this->content->expects($this->once())->method('getTitle')->willReturn('Foo');
        $this->content->expects($this->once())->method('getStatus')->willReturn('Accepted');

        $this->config->expects($this->any())->method('decisionRecordTemplateFile')->willReturn('template/skeleton.md');

        $record = new DecisionRecord($this->content, $this->config);

        $output = $record->output();

        $this->assertContains('# 1. Foo', $output);
        $this->assertContains(date('Y-m-d'), $output);
        $this->assertContains('Accepted', $output);
    }
}