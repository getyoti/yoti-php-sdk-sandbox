<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;

class SandboxSupplementaryDocumentTextDataExtractionTaskBuilder
{
    /**
     * @var array<string, mixed>|null
     */
    private $documentFields;

    /**
     * @var SandboxDocumentFilter
     */
    private $documentFilter;

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function withDocumentField(string $key, $value): self
    {
        $this->documentFields[$key] = $value;
        return $this;
    }

    /**
     * @param array<string, mixed> $documentFields
     * @return $this
     */
    public function withDocumentFields(array $documentFields): self
    {
        $this->documentFields = $documentFields;
        return $this;
    }

    /**
     * @param SandboxDocumentFilter $documentFilter
     *
     * @return $this
     */
    public function withDocumentFilter(SandboxDocumentFilter $documentFilter): self
    {
        $this->documentFilter = $documentFilter;
        return $this;
    }

    /**
     * @return SandboxSupplementaryDocumentTextDataExtractionTask
     */
    public function build(): SandboxSupplementaryDocumentTextDataExtractionTask
    {
        $result = new SandboxSupplementaryDocumentTextDataExtractionTaskResult($this->documentFields);
        return new SandboxSupplementaryDocumentTextDataExtractionTask($result, $this->documentFilter);
    }
}
