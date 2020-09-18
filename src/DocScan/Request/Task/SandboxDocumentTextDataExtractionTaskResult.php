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
     * @param array<string, mixed>|null $documentFields
     * @param SandboxDocumentIdPhoto|null $documentIdPhoto
     */
    public function __construct(?array $documentFields, ?SandboxDocumentIdPhoto $documentIdPhoto = null)
    {
        $this->documentFields = $documentFields;
        $this->documentIdPhoto = $documentIdPhoto;
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

        return $jsonData;
    }
}
