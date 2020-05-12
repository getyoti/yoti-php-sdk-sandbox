<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\SandboxCheckReports;
use Yoti\Sandbox\DocScan\Request\SandboxResponseConfigBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxTaskResults;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\SandboxResponseConfig
 */
class SandboxResponseConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxResponseConfigBuilder::withTaskResults
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxResponseConfigBuilder::withCheckReports
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxResponseConfigBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $taskResultsMock = $this->createMock(SandboxTaskResults::class);
        $taskResultsMock->method('jsonSerialize')->willReturn((object) [ 'some' => 'task' ]);

        $checkResultsMock = $this->createMock(SandboxCheckReports::class);
        $checkResultsMock->method('jsonSerialize')->willReturn((object) [ 'some' => 'check' ]);

        $responseConfig = (new SandboxResponseConfigBuilder())
            ->withTaskResults($taskResultsMock)
            ->withCheckReports($checkResultsMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'task_results' => $taskResultsMock,
                'check_reports' => $checkResultsMock,
            ]),
            json_encode($responseConfig)
        );
    }
}
