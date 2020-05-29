<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;
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
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxTaskResultsBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $documentTextExtractionTaskMock = $this->createMock(SandboxDocumentTextDataExtractionTask::class);
        $documentTextExtractionTaskMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentTextExtractionTaskMock' ]);

        $results = (new SandboxTaskResultsBuilder())
            ->withDocumentTextDataExtractionTask($documentTextExtractionTaskMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'ID_DOCUMENT_TEXT_DATA_EXTRACTION' => [
                    $documentTextExtractionTaskMock,
                ],
            ]),
            json_encode($results)
        );
    }
}
