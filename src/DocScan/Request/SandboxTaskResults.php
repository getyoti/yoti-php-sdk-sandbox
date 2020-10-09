<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;
use Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask;
use Yoti\Util\Json;

class SandboxTaskResults implements \JsonSerializable
{
    /**
     * @var SandboxDocumentTextDataExtractionTask[]
     */
    private $documentTextDataExtractionTasks;

    /**
     * @var SandboxSupplementaryDocumentTextDataExtractionTask[]|null
     */
    private $supplementaryDocumentTextDataExtractionTasks;

    /**
     * @param SandboxDocumentTextDataExtractionTask[] $documentTextDataExtractionTasks
     * @param SandboxSupplementaryDocumentTextDataExtractionTask[] $supplementaryDocumentTextDataExtractionTasks
     */
    public function __construct(
        array $documentTextDataExtractionTasks,
        ?array $supplementaryDocumentTextDataExtractionTasks
    ) {
        $this->documentTextDataExtractionTasks = $documentTextDataExtractionTasks;
        $this->supplementaryDocumentTextDataExtractionTasks = $supplementaryDocumentTextDataExtractionTasks;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'ID_DOCUMENT_TEXT_DATA_EXTRACTION' => $this->documentTextDataExtractionTasks,
            'SUPPLEMENTARY_DOCUMENT_TEXT_DATA_EXTRACTION' => $this->supplementaryDocumentTextDataExtractionTasks,
        ]);
    }
}
