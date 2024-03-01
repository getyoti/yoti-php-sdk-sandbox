<?php

declare(strict_types=1);

namespace Yoti\ShareUrl\Extension;

use stdClass;
use Yoti\Util\Json;
use Yoti\Util\Validation;

/**
 * Defines Extension for Dynamic Scenario.
 */
class Extension implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @param string $type
     * @param mixed $content
     */
    public function __construct(string $type, $content)
    {
        $this->type = $type;

        Validation::notNull($type, 'content');
        $this->content = $content;
    }

    /**
     * @inheritDoc
     *
     * @return stdClass
     */
    public function jsonSerialize(): stdClass
    {
        return (object)[
            'type' => $this->type,
            'content' => $this->content,
        ];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return Json::encode($this);
    }
}
