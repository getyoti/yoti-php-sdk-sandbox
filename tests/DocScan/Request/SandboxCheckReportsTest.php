<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxIdDocumentComparisonCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\Request\SandboxCheckReports;
use Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\SandboxCheckReports
 */
class SandboxCheckReportsTest extends TestCase
{
    private const SOME_ASYNC_REPORT_DELAY = 30;

    /**
     * @var SandboxDocumentTextDataCheck
     */
    private $documentTextDataCheckMock;

    /**
     * @var SandboxDocumentAuthenticityCheck
     */
    private $documentAuthenticityCheckMock;

    /**
     * @var SandboxDocumentFaceMatchCheck
     */
    private $documentFaceMatchCheckMock;

    /**
     * @var SandboxLivenessCheck
     */
    private $livenessCheckMock;

    /**
     * @var SandboxIdDocumentComparisonCheck
     */
    private $idDocumentComparisonCheckMock;

    public function setup(): void
    {
        $this->documentTextDataCheckMock = $this->createMock(SandboxDocumentTextDataCheck::class);
        $this->documentTextDataCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentTextDataCheck' ]);

        $this->documentAuthenticityCheckMock = $this->createMock(SandboxDocumentAuthenticityCheck::class);
        $this->documentAuthenticityCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentAuthenticityCheck' ]);

        $this->documentFaceMatchCheckMock = $this->createMock(SandboxDocumentFaceMatchCheck::class);
        $this->documentFaceMatchCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentFaceMatchCheck' ]);

        $this->livenessCheckMock = $this->createMock(SandboxLivenessCheck::class);
        $this->livenessCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'livenessCheck' ]);

        $this->idDocumentComparisonCheckMock = $this->createMock(SandboxIdDocumentComparisonCheck::class);
        $this->idDocumentComparisonCheckMock
            ->method('jsonSerialize')
            ->willReturn((object) [ 'type' => 'documentComparisonCheck' ]);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentTextDataCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentAuthenticityCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withIdDocumentComparisonCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withDocumentFaceMatchCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withLivenessCheck
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::withAsyncReportDelay
     * @covers \Yoti\Sandbox\DocScan\Request\SandboxCheckReportsBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $result = (new SandboxCheckReportsBuilder())
            ->withDocumentTextDataCheck($this->documentTextDataCheckMock)
            ->withDocumentAuthenticityCheck($this->documentAuthenticityCheckMock)
            ->withIdDocumentComparisonCheck($this->idDocumentComparisonCheckMock)
            ->withLivenessCheck($this->livenessCheckMock)
            ->withDocumentFaceMatchCheck($this->documentFaceMatchCheckMock)
            ->withAsyncReportDelay(self::SOME_ASYNC_REPORT_DELAY)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'ID_DOCUMENT_TEXT_DATA_CHECK' => [$this->documentTextDataCheckMock],
                'ID_DOCUMENT_AUTHENTICITY' => [$this->documentAuthenticityCheckMock],
                'ID_DOCUMENT_COMPARISON' => [$this->idDocumentComparisonCheckMock],
                'ID_DOCUMENT_FACE_MATCH' => [$this->documentFaceMatchCheckMock],
                'LIVENESS' => [$this->livenessCheckMock],
                'SUPPLEMENTARY_DOCUMENT_TEXT_DATA_CHECK' => [],
                'async_report_delay' => self::SOME_ASYNC_REPORT_DELAY
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldConstructWithoutOptionalArguments()
    {
        $checkReports = new SandboxCheckReports(
            [$this->documentTextDataCheckMock],
            [$this->documentAuthenticityCheckMock],
            [$this->documentFaceMatchCheckMock],
            [$this->livenessCheckMock],
            self::SOME_ASYNC_REPORT_DELAY
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'ID_DOCUMENT_TEXT_DATA_CHECK' => [$this->documentTextDataCheckMock],
                'ID_DOCUMENT_AUTHENTICITY' => [$this->documentAuthenticityCheckMock],
                'ID_DOCUMENT_FACE_MATCH' => [$this->documentFaceMatchCheckMock],
                'LIVENESS' => [$this->livenessCheckMock],
                'async_report_delay' => self::SOME_ASYNC_REPORT_DELAY,
            ]),
            json_encode($checkReports)
        );
    }
}
