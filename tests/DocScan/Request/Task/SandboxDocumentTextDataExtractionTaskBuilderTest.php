<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentIdPhoto;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskBuilder
 */
class SandboxDocumentTextDataExtractionTaskBuilderTest extends TestCase
{
    private const SOME_DOCUMENT_FIELD_KEY = 'someKey';
    private const SOME_DOCUMENT_FIELD_VALUE = 'someValue';
    private const SOME_OTHER_DOCUMENT_FIELD_KEY = 'someOtherKey';
    private const SOME_NESTED_DOCUMENT_FIELD_VALUE = [
        'someNestedKey' => 'someNestedValue'
    ];
    private const SOME_IMAGE_CONTENT_TYPE = 'image/jpeg';
    private const SOME_IMAGE_CONTENT = 'someImageContent';

    /**
     * @test
     * @covers ::withDocumentField
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowIndividualDocumentFields(): void
    {
        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
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
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldAllowOverridingOfDocumentFields(): void
    {
        $documentFields = [
            self::SOME_DOCUMENT_FIELD_KEY => self::SOME_DOCUMENT_FIELD_VALUE,
            self::SOME_OTHER_DOCUMENT_FIELD_KEY => self::SOME_NESTED_DOCUMENT_FIELD_VALUE
        ];

        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
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
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
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
                'result' => (object) [],
                'document_filter' => $documentFilter,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDocumentIdPhoto
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTaskResult::jsonSerialize
     */
    public function shouldHaveDocumentIdPhoto(): void
    {
        $result = (new SandboxDocumentTextDataExtractionTaskBuilder())
            ->withDocumentIdPhoto(self::SOME_IMAGE_CONTENT_TYPE, self::SOME_IMAGE_CONTENT)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'result' => [
                    'document_id_photo' => new SandboxDocumentIdPhoto(
                        self::SOME_IMAGE_CONTENT_TYPE,
                        self::SOME_IMAGE_CONTENT
                    ),
                ],
            ]),
            json_encode($result)
        );
    }
}
