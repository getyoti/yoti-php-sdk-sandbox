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
    private $content;

    /**
     * @param string $contentType
     * @param string $content
     */
    public function __construct(string $contentType, string $content)
    {
        $this->contentType = $contentType;
        $this->content = $content;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'content_type' => $this->contentType,
            'data' => base64_encode($this->content),
        ];
    }
}
