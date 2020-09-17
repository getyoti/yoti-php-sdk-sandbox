<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Util\Json;

class SandboxDocumentTextDataExtractionTaskResult implements \JsonSerializable
{
    /**
     * @var array<string, mixed>
     */
    private $documentFields;

    /**
     * @var SandboxDocumentIdPhoto|null
     */
    private $documentIdPhoto;

    /**
     * @param array<string, mixed> $documentFields
     * @param SandboxDocumentIdPhoto|null $documentIdPhoto
     */
    public function __construct(array $documentFields, ?SandboxDocumentIdPhoto $documentIdPhoto = null)
    {
        $this->documentFields = $documentFields;
        $this->documentIdPhoto = $documentIdPhoto;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'document_fields' => (object) $this->documentFields,
            'document_id_photo' => $this->documentIdPhoto,
        ]);
    }
}
