<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Check;

use PHPUnit\Framework\MockObject\MockObject;
use Yoti\Sandbox\DocScan\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\Check\SandboxZoomLivenessCheck;
use Yoti\Sandbox\DocScan\Check\SandboxZoomLivenessCheckBuilder;
use Yoti\Sandbox\DocScan\SandboxBreakdown;
use Yoti\Sandbox\DocScan\SandboxRecommendation;
use Yoti\Sandbox\Test\TestCase;

class SandboxZoomLivenessCheckBuilderTest extends TestCase
{

    /**
     * @var MockObject|SandboxRecommendation
     */
    private $recommendationMock;

    /**
     * @var MockObject|SandboxBreakdown
     */
    private $breakdownMock;

    /**
     * @before
     */
    public function setUp(): void
    {
        $this->recommendationMock = $this->createMock(SandboxRecommendation::class);
        $this->breakdownMock = $this->createMock(SandboxBreakdown::class);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenMissingRecommendation(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(SandboxRecommendation::class);

        (new SandboxZoomLivenessCheckBuilder())->build();
    }

    /**
     * @test
     */
    public function shouldBuildCorrectly(): void
    {
        $result = (new SandboxZoomLivenessCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->build();

        $this->assertInstanceOf(SandboxZoomLivenessCheck::class, $result);
        $this->assertInstanceOf(SandboxLivenessCheck::class, $result);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [
                            $this->breakdownMock
                        ],
                    ],
                ],
                'liveness_type' => 'ZOOM',
            ]),
            json_encode($result)
        );
    }
}
