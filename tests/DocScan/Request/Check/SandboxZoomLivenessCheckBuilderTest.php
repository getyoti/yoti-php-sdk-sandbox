<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check;

use PHPUnit\Framework\MockObject\MockObject;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdown;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendation;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxZoomLivenessCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxZoomLivenessCheckBuilder;
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

    /**
     * @test
     */
    public function shouldBuildWithHandledCheckLimit(): void
    {
        $result = (new SandboxZoomLivenessCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withHandledCheckLimit(5)
            ->build();

        $this->assertInstanceOf(SandboxZoomLivenessCheck::class, $result);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [],
                    ],
                ],
                'liveness_type' => 'ZOOM',
                'handled_check_limit' => 5,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     */
    public function shouldOmitHandledCheckLimitWhenNotSet(): void
    {
        $result = (new SandboxZoomLivenessCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->build();

        $serialized = json_encode($result);
        $this->assertStringNotContainsString('handled_check_limit', $serialized);
    }
}
