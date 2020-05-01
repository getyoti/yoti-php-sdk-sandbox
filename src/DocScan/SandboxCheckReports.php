<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

use Yoti\DocScan\Constants;
use Yoti\Sandbox\DocScan\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Check\SandboxLivenessCheck;
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
     */
    public function __construct(
        array $documentTextDataChecks,
        array $documentAuthenticityChecks,
        array $documentFaceMatchChecks,
        array $livenessChecks,
        ?int $asyncReportDelay
    ) {
        $this->documentTextDataChecks = $documentTextDataChecks;
        $this->documentAuthenticityChecks = $documentAuthenticityChecks;
        $this->documentFaceMatchChecks = $documentFaceMatchChecks;
        $this->livenessChecks = $livenessChecks;
        $this->asyncReportDelay = $asyncReportDelay;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            Constants::ID_DOCUMENT_TEXT_DATA_CHECK => $this->documentTextDataChecks,
            Constants::ID_DOCUMENT_AUTHENTICITY => $this->documentAuthenticityChecks,
            Constants::ID_DOCUMENT_FACE_MATCH => $this->documentFaceMatchChecks,
            Constants::LIVENESS => $this->livenessChecks,
            'async_report_delay' => $this->asyncReportDelay,
        ]);
    }
}
