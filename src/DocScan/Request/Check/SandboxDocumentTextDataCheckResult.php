<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxCheckReport;

class SandboxDocumentTextDataCheckResult extends SandboxCheckResult
{

    /**
     * @var array<string, mixed>
     */
    private $documentFields;

    /**
     * @param SandboxCheckReport $report
     * @param array<string, mixed> $documentFields
     */
    public function __construct(
        SandboxCheckReport $report,
        array $documentFields
    ) {
        parent::__construct($report);
        $this->documentFields = $documentFields;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $jsonData = parent::jsonSerialize();
        $jsonData->document_fields = (object) $this->documentFields;
        return $jsonData;
    }
}
