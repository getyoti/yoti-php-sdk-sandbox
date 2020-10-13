<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxSupplementaryDocumentTextDataExtractionTaskResult implements \JsonSerializable
{
    /**
     * @var array<string, mixed>|null
     */
    private $documentFields;

    /**
     * @var SandboxTextDataExtractionRecommendation|null
     */
    private $recommendation;

    /**
     * @var string|null
     */
    private $detectedCountry;

    /**
     * @param array<string, mixed>|null $documentFields
     */
    public function __construct(
        ?array $documentFields,
        ?string $detectedCountry = null,
        ?SandboxTextDataExtractionRecommendation $recommendation = null
    ) {
        $this->documentFields = $documentFields;
        $this->detectedCountry = $detectedCountry;
        $this->recommendation = $recommendation;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $jsonData = (object) [];

        if ($this->documentFields !== null) {
            $jsonData->document_fields = (object) $this->documentFields;
        }

        if ($this->detectedCountry !== null) {
            $jsonData->detected_country = $this->detectedCountry;
        }

        if ($this->recommendation !== null) {
            $jsonData->recommendation = $this->recommendation;
        }

        return $jsonData;
    }
}
