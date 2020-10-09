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
     * @param array<string, mixed>|null $documentFields
     */
    public function __construct(?array $documentFields)
    {
        $this->documentFields = $documentFields;
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

        return $jsonData;
    }
}
