<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentTextDataExtractionTask;
use Yoti\Sandbox\DocScan\Request\Task\SandboxSupplementaryDocumentTextDataExtractionTask;

class SandboxTaskResultsBuilder
{
    /**
     * @var SandboxDocumentTextDataExtractionTask[]
     */
    private $documentTextDataExtractionTasks = [];

    /**
     * @var SandboxSupplementaryDocumentTextDataExtractionTask[]
     */
    private $supplementaryDocumentTextDataExtractionTasks = [];

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
     * @param SandboxSupplementaryDocumentTextDataExtractionTask $supplementaryDocumentTextDataExtractionTask
     *
     * @return $this
     */
    public function withSupplementaryDocumentTextDataExtractionTask(
        SandboxSupplementaryDocumentTextDataExtractionTask $supplementaryDocumentTextDataExtractionTask
    ): self {
        $this->supplementaryDocumentTextDataExtractionTasks[] = $supplementaryDocumentTextDataExtractionTask;
        return $this;
    }

    /**
     * @return SandboxTaskResults
     */
    public function build()
    {
        return new SandboxTaskResults(
            $this->documentTextDataExtractionTasks,
            $this->supplementaryDocumentTextDataExtractionTasks
        );
    }
}
