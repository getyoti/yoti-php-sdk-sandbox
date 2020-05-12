<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;

class SandboxTaskResultsBuilder
{
    /**
     * @var SandboxDocumentTextDataExtractionTask[]
     */
    private $documentTextDataExtractionTasks = [];

    /**
     * @param SandboxDocumentTextDataExtractionTask $documentTextDataExtractionTask
     *
     * @return $this
     */
    public function withDocumentTextDataExtractionTask(
        SandboxDocumentTextDataExtractionTask $documentTextDataExtractionTask
    ): self {
        $this->documentTextDataExtractionTasks[] = $documentTextDataExtractionTask;
        return $this;
    }

    /**
     * @return SandboxTaskResults
     */
    public function build()
    {
        return new SandboxTaskResults($this->documentTextDataExtractionTasks);
    }
}
