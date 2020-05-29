<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\DocScan\Constants;
use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;

class SandboxTaskResults implements \JsonSerializable
{
    /**
     * @var SandboxDocumentTextDataExtractionTask[]
     */
    private $documentTextDataExtractionTasks;

    /**
     * @param SandboxDocumentTextDataExtractionTask[] $documentTextDataExtractionTasks
     */
    public function __construct(array $documentTextDataExtractionTasks)
    {
        $this->documentTextDataExtractionTasks = $documentTextDataExtractionTasks;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            Constants::ID_DOCUMENT_TEXT_DATA_EXTRACTION => $this->documentTextDataExtractionTasks,
        ];
    }
}
