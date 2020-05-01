<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxDocumentTextDataCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @var array<string, mixed>
     */
    private $documentFields = [];

    /**
     * @param string $key
     * @param mixed $value
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
     * @return SandboxDocumentTextDataCheck
     */
    public function build(): SandboxDocumentTextDataCheck
    {
        $result = new SandboxDocumentTextDataCheckResult($this->buildReport(), $this->documentFields);
        return new SandboxDocumentTextDataCheck($result, $this->documentFilter);
    }
}
