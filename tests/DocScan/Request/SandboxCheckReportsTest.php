<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentComparisonCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\SandboxCheckReports
 */
class SandboxCheckReportsTest extends TestCase
{

    private const SOME_ASYNC_REPORT_DELAY = 30;

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentTextDataCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentAuthenticityCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentComparisonCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentFaceMatchCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withLivenessCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withAsyncReportDelay
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::build
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

        $documentComparisonCheckMock = $this->createMock(SandboxDocumentComparisonCheck::class);
        $documentComparisonCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentComparisonCheck' ]);

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
            ->withDocumentComparisonCheck($documentComparisonCheckMock)
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
                'ID_DOCUMENT_COMPARISON' => [
                    $documentComparisonCheckMock,
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
