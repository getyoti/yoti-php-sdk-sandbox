<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check;

use PHPUnit\Framework\MockObject\MockObject;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdown;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendation;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheckBuilder;
use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Sandbox\Test\TestCase;

class SandboxDocumentTextDataCheckBuilderTest extends TestCase
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
     */
    public function shouldThrowExceptionWhenMissingRecommendation(): void
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(SandboxRecommendation::class);

        (new SandboxDocumentTextDataCheckBuilder())->build();
    }

    /**
     * @test
     */
    public function shouldBuildCorrectly(): void
    {
        $result = (new SandboxDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withBreakdown($this->breakdownMock)
            ->build();

        $this->assertInstanceOf(SandboxDocumentTextDataCheck::class, $result);

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
    public function shouldAllowAddingOfSingleDocumentFields(): void
    {
        $result = (new SandboxDocumentTextDataCheckBuilder())
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
     */
    public function shouldAllowOverwritingOfAllDocumentFields(): void
    {
        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
            self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
        ];

        $result = (new SandboxDocumentTextDataCheckBuilder())
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

        $result = (new SandboxDocumentTextDataCheckBuilder())
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
     */
    public function shouldBuildWithDocumentFilter(): void
    {
        $documentFilter = $this->createMock(SandboxDocumentFilter::class);
        $documentFilter
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'filter']);

        $result = (new SandboxDocumentTextDataCheckBuilder())
            ->withRecommendation($this->recommendationMock)
            ->withDocumentFilter($documentFilter)
            ->build();

        $this->assertInstanceOf(SandboxDocumentTextDataCheck::class, $result);

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
