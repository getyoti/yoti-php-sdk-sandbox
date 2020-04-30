<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\Attribute;

use Yoti\Util\Validation;

class SandboxAttribute implements \JsonSerializable
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /** @var string */
    protected $derivation;

    /** @var \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] */
    protected $anchors;

    /**
     * @param string $name
     * @param string $value
     * @param string $derivation
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     */
    public function __construct(
        string $name,
        string $value,
        string $derivation = '',
        $anchors = []
    ) {
        $this->name = $name;
        $this->value = $value;
        $this->derivation = $derivation;

        $args = func_get_args();
        if (isset($args[3]) && is_bool($args[3])) {
            @trigger_error(
                'Boolean argument 4 passed to ' . __METHOD__ . ' is deprecated in 1.1.0 ' .
                'and will be removed in 2.0.0',
                E_USER_DEPRECATED
            );
            $anchors = $args[4] ?? [];
        }

        Validation::isArrayOfType($anchors, [\Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor::class], 'anchors');
        $this->anchors = $anchors;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'derivation' => $this->derivation,
            'anchors' => $this->anchors,
        ];
    }
}
