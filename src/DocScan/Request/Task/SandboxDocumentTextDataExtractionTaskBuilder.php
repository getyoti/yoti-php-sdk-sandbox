<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;

class SandboxDocumentTextDataExtractionTaskBuilder
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
     * @var SandboxDocumentIdPhoto
     */
    private $documentIdPhoto;

    /**
     * @var SandboxTextDataExtractionRecommendation|null
     */
    private $recommendation;

    /**
     * @var string|null
     */
    private $detectedCountry;

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
     * @param string $contentType
     * @param string $data
     *
     * @return $this
     */
    public function withDocumentIdPhoto(string $contentType, string $data): self
    {
        $this->documentIdPhoto = new SandboxDocumentIdPhoto($contentType, $data);
        return $this;
    }

    /**
     * @param SandboxTextDataExtractionRecommendation $recommendation
     *
     * @return self
     */
    public function withRecommendation(SandboxTextDataExtractionRecommendation $recommendation): self
    {
        $this->recommendation = $recommendation;
        return $this;
    }

    /**
     * @param string $detectedCountry
     *
     * @return $this
     */
    public function withDetectedCountry(string $detectedCountry): self
    {
        $this->detectedCountry = $detectedCountry;
        return $this;
    }

    /**
     * @return SandboxDocumentTextDataExtractionTask
     */
    public function build(): SandboxDocumentTextDataExtractionTask
    {
        $result = new SandboxDocumentTextDataExtractionTaskResult(
            $this->documentFields,
            $this->documentIdPhoto,
            $this->detectedCountry,
            $this->recommendation
        );
        return new SandboxDocumentTextDataExtractionTask($result, $this->documentFilter);
    }
}
