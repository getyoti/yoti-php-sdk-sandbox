<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentAuthenticityCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentFaceMatchCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxDocumentTextDataCheck;
use Yoti\Sandbox\DocScan\Request\Check\SandboxLivenessCheck;

class SandboxCheckReportsBuilder
{

    /**
     * @var SandboxDocumentTextDataCheck[]
     */
    private $documentTextDataChecks = [];

    /**
     * @var SandboxDocumentAuthenticityCheck[]
     */
    private $documentAuthenticityChecks = [];

    /**
     * @var SandboxDocumentFaceMatchCheck[]
     */
    private $documentFaceMatchChecks = [];

    /**
     * @var SandboxLivenessCheck[]
     */
    private $livenessChecks = [];

    /**
     * @var int
     */
    private $asyncReportDelay;

    /**
     * @param SandboxDocumentTextDataCheck $documentTextDataCheck
     * @return $this
     */
    public function withDocumentTextDataCheck(SandboxDocumentTextDataCheck $documentTextDataCheck): self
    {
        $this->documentTextDataChecks[] = $documentTextDataCheck;
        return $this;
    }

    /**
     * @param SandboxDocumentAuthenticityCheck $documentAuthenticityCheck
     * @return $this
     */
    public function withDocumentAuthenticityCheck(SandboxDocumentAuthenticityCheck $documentAuthenticityCheck): self
    {
        $this->documentAuthenticityChecks[] = $documentAuthenticityCheck;
        return $this;
    }

    /**
     * @param SandboxLivenessCheck $livenessCheck
     * @return $this
     */
    public function withLivenessCheck(SandboxLivenessCheck $livenessCheck): self
    {
        $this->livenessChecks[] = $livenessCheck;
        return $this;
    }

    /**
     * @param SandboxDocumentFaceMatchCheck $documentFaceMatchCheck
     * @return $this
     */
    public function withDocumentFaceMatchCheck(SandboxDocumentFaceMatchCheck $documentFaceMatchCheck): self
    {
        $this->documentFaceMatchChecks[] = $documentFaceMatchCheck;
        return $this;
    }

    /**
     * @param int $asyncReportDelay
     * @return $this
     */
    public function withAsyncReportDelay(int $asyncReportDelay): self
    {
        $this->asyncReportDelay = $asyncReportDelay;
        return $this;
    }

    /**
     * @return SandboxCheckReports
     */
    public function build(): SandboxCheckReports
    {
        return new SandboxCheckReports(
            $this->documentTextDataChecks,
            $this->documentAuthenticityChecks,
            $this->documentFaceMatchChecks,
            $this->livenessChecks,
            $this->asyncReportDelay
        );
    }
}
