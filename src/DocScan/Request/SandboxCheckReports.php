<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxIdDocumentComparisonCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxSupplementaryDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxThirdPartyIdentityCheck;
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
     * @var SandboxThirdPartyIdentityCheck|null
     */
    private $thirdPartyIdentityCheck;

    /**
     * @var SandboxSupplementaryDocumentTextDataCheck[]|null
     */
    private $supplementaryDocumentTextDataChecks;

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
     * @param SandboxSupplementaryDocumentTextDataCheck[]|null $supplementaryDocumentTextDataChecks
     * @param SandboxThirdPartyIdentityCheck|null $thirdPartyIdentityCheck
     */
    public function __construct(
        array $documentTextDataChecks,
        array $documentAuthenticityChecks,
        array $documentFaceMatchChecks,
        array $livenessChecks,
        ?int $asyncReportDelay,
        ?array $idDocumentComparisonChecks = null,
        ?array $supplementaryDocumentTextDataChecks = null,
        SandboxThirdPartyIdentityCheck $thirdPartyIdentityCheck = null
    ) {
        $this->documentTextDataChecks = $documentTextDataChecks;
        $this->documentAuthenticityChecks = $documentAuthenticityChecks;
        $this->documentFaceMatchChecks = $documentFaceMatchChecks;
        $this->livenessChecks = $livenessChecks;
        $this->asyncReportDelay = $asyncReportDelay;
        $this->idDocumentComparisonChecks = $idDocumentComparisonChecks;
        $this->supplementaryDocumentTextDataChecks = $supplementaryDocumentTextDataChecks;
        $this->thirdPartyIdentityCheck = $thirdPartyIdentityCheck;
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
            'SUPPLEMENTARY_DOCUMENT_TEXT_DATA_CHECK' => $this->supplementaryDocumentTextDataChecks,
            'LIVENESS' => $this->livenessChecks,
            'THIRD_PARTY_IDENTITY' => $this->thirdPartyIdentityCheck,
            'async_report_delay' => $this->asyncReportDelay,
        ]);
    }
}
