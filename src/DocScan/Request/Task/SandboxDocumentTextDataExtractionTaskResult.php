<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxDocumentTextDataExtractionTaskResult implements \JsonSerializable
{

    /**
     * @var array<string, mixed>
     */
    private $documentFields;

    /**
     * SandboxTaskResult constructor.
     * @param array<string, mixed> $documentFields
     */
    public function __construct(array $documentFields)
    {
        $this->documentFields = $documentFields;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'document_fields' => (object) $this->documentFields,
        ];
    }
}
