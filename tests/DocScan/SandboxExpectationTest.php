<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\SandboxCheckReports;
use Yoti\Sandbox\DocScan\SandboxExpectationBuilder;
use Yoti\Sandbox\DocScan\SandboxTaskResults;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxExpectation
 */
class SandboxExpectationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxExpectationBuilder::withTaskResults
     * @covers \Yoti\Sandbox\DocScan\SandboxExpectationBuilder::withCheckReports
     * @covers \Yoti\Sandbox\DocScan\SandboxExpectationBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $taskResultsMock = $this->createMock(SandboxTaskResults::class);
        $taskResultsMock->method('jsonSerialize')->willReturn((object) [ 'some' => 'task' ]);

        $checkResultsMock = $this->createMock(SandboxCheckReports::class);
        $checkResultsMock->method('jsonSerialize')->willReturn((object) [ 'some' => 'check' ]);

        $expectation = (new SandboxExpectationBuilder())
            ->withTaskResults($taskResultsMock)
            ->withCheckReports($checkResultsMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'task_results' => $taskResultsMock,
                'check_reports' => $checkResultsMock,
            ]),
            json_encode($expectation)
        );
    }
}
