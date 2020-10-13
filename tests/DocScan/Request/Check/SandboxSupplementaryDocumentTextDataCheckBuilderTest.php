<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check;

use PHPUnit\Framework\MockObject\MockObject;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdown;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendation;
use Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheckBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheckBuilder
 */
class SandboxSupplementaryDocumentTextDataCheckBuilderTest extends TestCase
{
    private const SOME_DOCUMENT_FIELD_KEY = 'someKey';
    private const SOME_DOCUMENT_FIELD_VALUE = 'someValue';
    private const SOME_OTHER_DOCUMENT_FIELD_KEY = 'someOtherKey';
    private const SOME_NESTED_DOCUMENT_FIELD_VALUE = [
        'someNestedKey' => 'someNestedValue'
    ];

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
     * @covers ::build
     */
    public function shouldThrowExceptionWhenMissingRecommendation(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(SandboxRecommendation::class);

        (new SandboxSupplementaryDocumentTextDataCheckBuilder())->build();
    }

    /**
     * @test
     * @covers ::withRecommendation
     * @covers ::withBreakdown
     * @covers ::build
     */
    public function shouldBuildCorrectly(): void
    {
        $result = (new SandboxSupplementaryDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->build();

        $this->assertInstanceOf(SandboxSupplementaryDocumentTextDataCheck::class, $result);

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
     * @covers ::withDocumentField
     */
    public function shouldAllowAddingOfSingleDocumentFields(): void
    {
        $result = (new SandboxSupplementaryDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->withDocumentField(self::SOME_DOCUMENT_FIELD_KEY, self::SOME_DOCUMENT_FIELD_VALUE)
            ->withDocumentField(self::SOME_OTHER_DOCUMENT_FIELD_KEY, self::SOME_NESTED_DOCUMENT_FIELD_VALUE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [
                            $this->breakdownMock,
                        ],
                    ],
                    'document_fields' => [
                        self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
                        self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
                    ],
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentFields
     */
    public function shouldAllowOverwritingOfAllDocumentFields(): void
    {
        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
            self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
        ];

        $result = (new SandboxSupplementaryDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->withDocumentFields($documentFields)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [
                            $this->breakdownMock,
                        ],
                    ],
                    'document_fields' => $documentFields,
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers \Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheck::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheck::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheckResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheckResult::jsonSerialize
     */
    public function shouldSerializeToJsonCorrectly()
    {
        $this->recommendationMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'someRecommendationKey' => 'someRecommendationValue' ]);

        $this->breakdownMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'someBreakdownKey' => 'someBreakdownValue' ]);

        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
            self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
        ];

        $result = (new SandboxSupplementaryDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->withDocumentFields($documentFields)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'report' => [
                        'recommendation' => $this->recommendationMock,
                        'breakdown' => [
                            $this->breakdownMock,
                        ],
                    ],
                    'document_fields' => $documentFields,
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentFilter
     */
    public function shouldBuildWithDocumentFilter(): void
    {
        $documentFilter = $this->createMock(SandboxDocumentFilter::class);
        $documentFilter
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'filter']);

        $result = (new SandboxSupplementaryDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withDocumentFilter($documentFilter)
            ->build();

        $this->assertInstanceOf(SandboxSupplementaryDocumentTextDataCheck::class, $result);

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
