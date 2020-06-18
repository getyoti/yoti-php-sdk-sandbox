<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData;

abstract class SandboxDataEntry implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var \JsonSerializable
     */
    private $value;

    /**
     * @param string $type
     * @param \JsonSerializable $value
     */
    public function __construct(string $type, \JsonSerializable $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'type' => $this->type,
            'value' => $this->value,
        ];
    }
}
