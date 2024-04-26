<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check\Report;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxDetail;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdown
 */
class SandboxBreakdownTest extends TestCase
{
    private const SOME_SUB_CHECK = 'someSubCheck';
    private const SOME_RESULT = 'someResult';

    private const SOME_DETAILS_NAME = 'someDetailsName';
    private const SOME_DETAILS_VALUE = 'someDetailsValue';

    /**
     * @test
     * @covers ::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder::withSubCheck
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder::withResult
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder::withDetail
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $result = (new SandboxBreakdownBuilder())
            ->withSubCheck(self::SOME_SUB_CHECK)
            ->withResult(self::SOME_RESULT)
            ->withDetail(self::SOME_DETAILS_NAME, self::SOME_DETAILS_VALUE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'sub_check' => self::SOME_SUB_CHECK,
                'result' => self::SOME_RESULT,
                'details' => [
                    [
                        'name' => self::SOME_DETAILS_NAME,
                        'value' => self::SOME_DETAILS_VALUE,
                    ],
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdownBuilder::withDetails
     */
    public function shouldAllowArrayOfDetails()
    {
        $details = [
            $this->createMock(SandboxDetail::class),
            $this->createMock(SandboxDetail::class)
        ];

        $result = (new SandboxBreakdownBuilder())
            ->withSubCheck(self::SOME_SUB_CHECK)
            ->withResult(self::SOME_RESULT)
            ->withDetails($details)
            ->build();

            $this->assertJsonStringEqualsJsonString(
                json_encode([
                    'sub_check' => self::SOME_SUB_CHECK,
                    'result' => self::SOME_RESULT,
                    'details' => $details,
                ]),
                json_encode($result)
            );
    }

    /**
     * @test
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJsonCorrectly()
    {
        $detailsMock = $this->createMock(SandboxDetail::class);
        $detailsMock
            ->method('jsonSerialize')
            ->willReturn((object) ['id' => 'someMock']);

        $details = [$detailsMock];

        $result = (new SandboxBreakdownBuilder())
            ->withSubCheck(self::SOME_SUB_CHECK)
            ->withResult(self::SOME_RESULT)
            ->withDetails($details)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'sub_check' => self::SOME_SUB_CHECK,
                'result' => self::SOME_RESULT,
                'details' => $details,
            ]),
            json_encode($result)
        );
    }
}
