<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxCheckReport;

class SandboxDocumentTextDataCheckResult extends SandboxCheckResult
{
    /**
     * @var array<string, mixed>|null
     */
    private $documentFields;

    /**
     * @param SandboxCheckReport $report
     * @param array<string, mixed>|null $documentFields
     */
    public function __construct(
        SandboxCheckReport $report,
        ?array $documentFields
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

        if ($this->documentFields !== null) {
            $jsonData->document_fields = (object) $this->documentFields;
        }

        return $jsonData;
    }
}
