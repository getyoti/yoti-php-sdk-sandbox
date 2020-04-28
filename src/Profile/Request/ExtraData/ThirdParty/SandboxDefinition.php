<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty;

use Yoti\Util\Validation;

class SandboxDefinition implements \JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        Validation::notEmptyString($name, 'name');
        $this->name = $name;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'name' => $this->name,
        ];
    }
}
