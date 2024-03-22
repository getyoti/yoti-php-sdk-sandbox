<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;
use Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\SandboxTaskResults
 */
class SandboxTaskResultsTest extends TestCase
{
    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder::withDocumentTextDataExtractionTask
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder::withSupplementaryDocumentTextDataExtractionTask
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $documentTextExtractionTaskMock = $this->createMock(SandboxDocumentTextDataExtractionTask::class);
        $documentTextExtractionTaskMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentTextExtractionTaskMock' ]);

        $supplementaryDocumentTextExtractionTaskMock = $this->createMock(
            SandboxSupplementaryDocumentTextDataExtractionTask::class
        );
        $supplementaryDocumentTextExtractionTaskMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'supplementaryDocumentTextExtractionTaskMock' ]);

        $results = (new SandboxTaskResultsBuilder())
            ->withDocumentTextDataExtractionTask($documentTextExtractionTaskMock)
            ->withSupplementaryDocumentTextDataExtractionTask($supplementaryDocumentTextExtractionTaskMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'ID_DOCUMENT_TEXT_DATA_EXTRACTION' => [
                    $documentTextExtractionTaskMock,
                ],
                'SUPPLEMENTARY_DOCUMENT_TEXT_DATA_EXTRACTION' => [
                    $supplementaryDocumentTextExtractionTaskMock,
                ],
            ]),
            json_encode($results)
        );
    }
}
