<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxDocumentTextDataExtractionTaskResult implements \JsonSerializable
{
    /**
     * @var array<string, mixed>|null
     */
    private $documentFields;

    /**
     * @var SandboxDocumentIdPhoto|null
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
     * @param array<string, mixed>|null $documentFields
     * @param SandboxDocumentIdPhoto|null $documentIdPhoto
     * @param string|null $detectedCountry
     * @param SandboxTextDataExtractionRecommendation|null $recommendation
     */
    public function __construct(
        ?array $documentFields,
        ?SandboxDocumentIdPhoto $documentIdPhoto = null,
        ?string $detectedCountry = null,
        ?SandboxTextDataExtractionRecommendation $recommendation = null
    ) {
        $this->documentFields = $documentFields;
        $this->documentIdPhoto = $documentIdPhoto;
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

        if ($this->documentIdPhoto !== null) {
            $jsonData->document_id_photo = $this->documentIdPhoto;
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
