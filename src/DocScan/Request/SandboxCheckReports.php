<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxIdDocumentComparisonCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;
use Yoti\Util\Json;

class SandboxCheckReports implements \JsonSerializable
{

    /**
     * @var SandboxDocumentTextDataCheck[]
     */
    private $documentTextDataChecks;

    /**
     * @var SandboxDocumentAuthenticityCheck[]
     */
    private $documentAuthenticityChecks;

    /**
     * @var SandboxIdDocumentComparisonCheck[]|null
     */
    private $idDocumentComparisonChecks;

    /**
     * @var SandboxDocumentFaceMatchCheck[]
     */
    private $documentFaceMatchChecks;

    /**
     * @var SandboxLivenessCheck[]
     */
    private $livenessChecks;

    /**
     * @var int|null
     */
    private $asyncReportDelay;

    /**
     * SandboxCheckReport constructor.
     *
     * @param SandboxDocumentTextDataCheck[] $documentTextDataChecks
     * @param SandboxDocumentAuthenticityCheck[] $documentAuthenticityChecks
     * @param SandboxDocumentFaceMatchCheck[] $documentFaceMatchChecks
     * @param SandboxLivenessCheck[] $livenessChecks
     * @param int|null $asyncReportDelay
     * @param SandboxIdDocumentComparisonCheck[]|null $idDocumentComparisonChecks
     */
    public function __construct(
        array $documentTextDataChecks,
        array $documentAuthenticityChecks,
        array $documentFaceMatchChecks,
        array $livenessChecks,
        ?int $asyncReportDelay,
        ?array $idDocumentComparisonChecks = null
    ) {
        $this->documentTextDataChecks = $documentTextDataChecks;
        $this->documentAuthenticityChecks = $documentAuthenticityChecks;
        $this->documentFaceMatchChecks = $documentFaceMatchChecks;
        $this->livenessChecks = $livenessChecks;
        $this->asyncReportDelay = $asyncReportDelay;
        $this->idDocumentComparisonChecks = $idDocumentComparisonChecks;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'ID_DOCUMENT_TEXT_DATA_CHECK' => $this->documentTextDataChecks,
            'ID_DOCUMENT_AUTHENTICITY' => $this->documentAuthenticityChecks,
            'ID_DOCUMENT_FACE_MATCH' => $this->documentFaceMatchChecks,
            'ID_DOCUMENT_COMPARISON' => $this->idDocumentComparisonChecks,
            'LIVENESS' => $this->livenessChecks,
            'async_report_delay' => $this->asyncReportDelay,
        ]);
    }
}
