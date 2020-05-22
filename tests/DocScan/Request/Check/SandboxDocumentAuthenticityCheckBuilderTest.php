<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check;

use PHPUnit\Framework\MockObject\MockObject;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheckBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxBreakdown;
use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Sandbox\DocScan\Request\SandboxRecommendation;
use Yoti\Sandbox\Test\TestCase;

class SandboxDocumentAuthenticityCheckBuilderTest extends TestCase
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

        (new SandboxDocumentAuthenticityCheckBuilder())->build();
    }

    /**
     * @test
     */
    public function shouldBuildCorrectly(): void
    {
        $result = (new SandboxDocumentAuthenticityCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->build();

        $this->assertInstanceOf(SandboxDocumentAuthenticityCheck::class, $result);

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
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     */
    public function shouldAllowOverwritingOfBreakdowns(): void
    {
        $breakdowns = [
            $this->breakdownMock,
            $this->breakdownMock,
            $this->breakdownMock
        ];

        $result = (new SandboxDocumentAuthenticityCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdowns($breakdowns)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [
                            $this->breakdownMock,
                            $this->breakdownMock,
                            $this->breakdownMock,
                        ],
                    ],
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     */
    public function shouldBuildWithDocumentFilter(): void
    {
        $documentFilter = $this->createMock(SandboxDocumentFilter::class);
        $documentFilter
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'filter']);

        $result = (new SandboxDocumentAuthenticityCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withDocumentFilter($documentFilter)
            ->build();

        $this->assertInstanceOf(SandboxDocumentAuthenticityCheck::class, $result);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [],
                    ],
                ],
                'document_filter' => $documentFilter
            ]),
            json_encode($result)
        );
    }
}
