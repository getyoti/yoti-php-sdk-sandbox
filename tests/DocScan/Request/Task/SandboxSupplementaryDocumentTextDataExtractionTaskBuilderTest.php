<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskBuilder;
use Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskBuilder
 */
class SandboxSupplementaryDocumentTextDataExtractionTaskBuilderTest extends TestCase
{
    private const SOME_DOCUMENT_FIELD_KEY = 'someKey';
    private const SOME_DOCUMENT_FIELD_VALUE = 'someValue';
    private const SOME_OTHER_DOCUMENT_FIELD_KEY = 'someOtherKey';
    private const SOME_NESTED_DOCUMENT_FIELD_VALUE = [
        'someNestedKey' => 'someNestedValue'
    ];
    private const SOME_COUNTRY = 'someCountry';

    /**
     * @test
     * @covers ::withDocumentField
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowIndividualDocumentFields(): void
    {
        $result = (new SandboxSupplementaryDocumentTextDataExtractionTaskBuilder())
            ->withDocumentField(self::SOME_DOCUMENT_FIELD_KEY, self::SOME_DOCUMENT_FIELD_VALUE)
            ->withDocumentField(self::SOME_OTHER_DOCUMENT_FIELD_KEY, self::SOME_NESTED_DOCUMENT_FIELD_VALUE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_fields' => [
                        self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
                        self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE,
                    ],
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentFields
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowOverridingOfDocumentFields(): void
    {
        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
            self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
        ];

        $result = (new SandboxSupplementaryDocumentTextDataExtractionTaskBuilder())
            ->withDocumentFields($documentFields)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_fields' => $documentFields,
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentFilter
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldHaveDocumentFilter(): void
    {
        $documentFilter = $this->createMock(SandboxDocumentFilter::class);
        $documentFilter
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'filter']);

        $result = (new SandboxSupplementaryDocumentTextDataExtractionTaskBuilder())
            ->withDocumentFilter($documentFilter)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => (object) [],
                'document_filter' => $documentFilter,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDetectedCountry
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldHaveDetectedCountry(): void
    {
        $result = (new SandboxSupplementaryDocumentTextDataExtractionTaskBuilder())
            ->withDetectedCountry(self::SOME_COUNTRY)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'detected_country' => self::SOME_COUNTRY,
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withRecommendation
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldHaveRecommendation(): void
    {
        $someRecommendationMock = $this->createMock(SandboxTextDataExtractionRecommendation::class);
        $someRecommendationMock
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'recommendation']);

        $result = (new SandboxSupplementaryDocumentTextDataExtractionTaskBuilder())
            ->withRecommendation($someRecommendationMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'recommendation' => $someRecommendationMock,
                ],
            ]),
            json_encode($result)
        );
    }
}
