<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;

abstract class SandboxDocumentCheck extends SandboxCheck implements \JsonSerializable
{
    /**
     * @var SandboxDocumentFilter|null
     */
    private $documentFilter;

    /**
     * @param SandboxCheckResult $result
     * @param SandboxDocumentFilter|null $documentFilter
     */
    public function __construct(SandboxCheckResult $result, ?SandboxDocumentFilter $documentFilter)
    {
        parent::__construct($result);

        $this->documentFilter = $documentFilter;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $jsonData = parent::jsonSerialize();

        if (isset($this->documentFilter)) {
            $jsonData->document_filter = $this->documentFilter;
        }

        return $jsonData;
    }
}
