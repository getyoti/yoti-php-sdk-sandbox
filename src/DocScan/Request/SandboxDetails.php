<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

class SandboxDetails implements \JsonSerializable
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'name' => $this->getName(),
            'value' => $this->getValue(),
        ];
    }
}
