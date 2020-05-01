<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\SandboxBreakdown;
use Yoti\Sandbox\DocScan\SandboxBreakdownBuilder;
use Yoti\Sandbox\DocScan\SandboxDetails;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxBreakdown
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
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::withSubCheck
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::withResult
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::withDetail
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::build
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
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::withDetails
     */
    public function shouldAllowArrayOfDetails()
    {
        $details = [
            $this->createMock(SandboxDetails::class),
            $this->createMock(SandboxDetails::class)
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
        $detailsMock = $this->createMock(SandboxBreakdown::class);
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

    /**
     * @test
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::passForCheck
     */
    public function passForCheckShouldReturnCorrectValues()
    {
        $result = SandboxBreakdownBuilder::passForCheck(self::SOME_SUB_CHECK);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'sub_check' => self::SOME_SUB_CHECK,
                'result' => 'PASS',
                'details' => [],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers \Yoti\Sandbox\DocScan\SandboxBreakdownBuilder::failForCheck
     */
    public function failForCheckShouldReturnCorrectValues()
    {
        $result = SandboxBreakdownBuilder::failForCheck(self::SOME_SUB_CHECK);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'sub_check' => self::SOME_SUB_CHECK,
                'result' => 'FAIL',
                'details' => [],
            ]),
            json_encode($result)
        );
    }
}
