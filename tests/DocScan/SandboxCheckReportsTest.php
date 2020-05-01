<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxCheckReports
 */
class SandboxCheckReportsTest extends TestCase
{

    private const SOME_ASYNC_REPORT_DELAY = 30;

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::withDocumentTextDataCheck
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::withDocumentAuthenticityCheck
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::withDocumentFaceMatchCheck
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::withLivenessCheck
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::withAsyncReportDelay
     * @covers \Yoti\Sandbox\DocScan\SandboxCheckReportsBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $documentTextDataCheckMock = $this->createMock(SandboxDocumentTextDataCheck::class);
        $documentTextDataCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentTextDataCheck' ]);

        $documentAuthenticityCheckMock = $this->createMock(SandboxDocumentAuthenticityCheck::class);
        $documentAuthenticityCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentAuthenticityCheck' ]);

        $documentFaceMatchCheckMock = $this->createMock(SandboxDocumentFaceMatchCheck::class);
        $documentFaceMatchCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentFaceMatchCheck' ]);

        $livenessCheckMock = $this->createMock(SandboxLivenessCheck::class);
        $livenessCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'livenessCheck' ]);

        $result = (new SandboxCheckReportsBuilder())
            ->withDocumentTextDataCheck($documentTextDataCheckMock)
            ->withDocumentAuthenticityCheck($documentAuthenticityCheckMock)
            ->withLivenessCheck($livenessCheckMock)
            ->withDocumentFaceMatchCheck($documentFaceMatchCheckMock)
            ->withAsyncReportDelay(self::SOME_ASYNC_REPORT_DELAY)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'ID_DOCUMENT_TEXT_DATA_CHECK' => [
                    $documentTextDataCheckMock,
                ],
                'ID_DOCUMENT_AUTHENTICITY' => [
                    $documentAuthenticityCheckMock,
                ],
                'ID_DOCUMENT_FACE_MATCH' => [
                    $documentFaceMatchCheckMock,
                ],
                'LIVENESS' => [
                    $livenessCheckMock,
                ],
                'async_report_delay' => self::SOME_ASYNC_REPORT_DELAY
            ]),
            json_encode($result)
        );
    }
}
