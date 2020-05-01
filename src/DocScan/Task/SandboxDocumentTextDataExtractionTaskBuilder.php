<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Task;

use Yoti\Sandbox\DocScan\SandboxDocumentFilter;

class SandboxDocumentTextDataExtractionTaskBuilder
{

    /**
     * @var array<string, mixed>
     */
    private $documentFields = [];

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
     * @return SandboxDocumentTextDataExtractionTask
     */
    public function build(): SandboxDocumentTextDataExtractionTask
    {
        $result = new SandboxDocumentTextDataExtractionTaskResult($this->documentFields);
        return new SandboxDocumentTextDataExtractionTask($result, $this->documentFilter);
    }
}
