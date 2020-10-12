<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;
use Yoti\Util\Json;

class SandboxDocumentTextDataExtractionTask implements \JsonSerializable
{
    /**
     * @var SandboxDocumentTextDataExtractionTaskResult
     */
    private $result;

    /**
     * @var SandboxDocumentFilter|null
     */
    private $documentFilter;

    /**
     * @param SandboxDocumentTextDataExtractionTaskResult $result
     */
    public function __construct(
        SandboxDocumentTextDataExtractionTaskResult $result,
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
