<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Task;

use Yoti\Sandbox\DocScan\SandboxDocumentFilter;
use Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskBuilder
 */
class SandboxDocumentTextDataExtractionTaskBuilderTest extends TestCase
{

    private const SOME_DOCUMENT_FIELD_KEY = 'someKey';
    private const SOME_DOCUMENT_FIELD_VALUE = 'someValue';

    /**
     * @test
     * @covers ::withDocumentField
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowIndividualDocumentFields(): void
    {
        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
            ->withDocumentField(self::SOME_DOCUMENT_FIELD_KEY, self::SOME_DOCUMENT_FIELD_VALUE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_fields' => [
                        self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
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
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowOverridingOfDocumentFields(): void
    {
        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
        ];

        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
            ->withDocumentFields($documentFields)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_fields' => [
                        self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
                    ],
                ],
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentFilter
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldHaveDocumentFilter(): void
    {
        $documentFilter = $this->createMock(SandboxDocumentFilter::class);
        $documentFilter
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'filter']);

        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
            ->withDocumentFilter($documentFilter)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_fields' => (object) [],
                ],
                'document_filter' => $documentFilter,
            ]),
            json_encode($result)
        );
    }
}
