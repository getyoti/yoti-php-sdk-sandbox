<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Util\Json;

class SandboxSupplementaryDocumentTextDataExtractionTask implements \JsonSerializable
{
    /**
     * @var SandboxSupplementaryDocumentTextDataExtractionTaskResult
     */
    private $result;

    /**
     * @var SandboxDocumentFilter|null
     */
    private $documentFilter;

    /**
     * @param SandboxSupplementaryDocumentTextDataExtractionTaskResult $result
     */
    public function __construct(
        SandboxSupplementaryDocumentTextDataExtractionTaskResult $result,
        ?SandboxDocumentFilter $documentFilter
    ) {
        $this->result = $result;
        $this->documentFilter = $documentFilter;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'result' => $this->result,
            'document_filter' => $this->documentFilter,
        ]);
    }
}
