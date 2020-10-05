<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;

class SandboxIdDocumentComparisonCheck extends SandboxCheck implements \JsonSerializable
{
    /**
     * @var SandboxDocumentFilter|null
     */
    private $secondaryDocumentFilter;

    /**
     * @param SandboxCheckResult $result
     * @param SandboxDocumentFilter|null $secondaryDocumentFilter
     */
    public function __construct(SandboxCheckResult $result, ?SandboxDocumentFilter $secondaryDocumentFilter)
    {
        parent::__construct($result);

        $this->secondaryDocumentFilter = $secondaryDocumentFilter;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $jsonData = parent::jsonSerialize();

        if (isset($this->secondaryDocumentFilter)) {
            $jsonData->secondary_document_filter = $this->secondaryDocumentFilter;
        }

        return $jsonData;
    }
}
