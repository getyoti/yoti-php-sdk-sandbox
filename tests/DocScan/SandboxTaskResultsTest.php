<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\SandboxTaskResultsBuilder;
use Yoti\Sandbox\DocScan\Task\SandboxDocumentTextDataExtractionTask;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxTaskResults
 */
class SandboxTaskResultsTest extends TestCase
{

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxTaskResultsBuilder::withDocumentTextDataExtractionTask
     * @covers \Yoti\Sandbox\DocScan\SandboxTaskResultsBuilder::build
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
