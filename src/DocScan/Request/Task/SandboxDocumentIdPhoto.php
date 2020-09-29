<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxDocumentIdPhoto implements \JsonSerializable
{
    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $data;

    /**
     * @param string $contentType
     * @param string $data
     */
    public function __construct(string $contentType, string $data)
    {
        $this->contentType = $contentType;
        $this->data = $data;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'content_type' => $this->contentType,
            'data' => base64_encode($this->data),
        ];
    }
}
