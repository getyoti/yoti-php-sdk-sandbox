<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Util\Json;

class SandboxTextDataExtractionReason implements \JsonSerializable
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $detail;

    /**
     * @param string $value
     * @param string|null $detail
     */
    public function __construct(
        string $value,
        ?string $detail
    ) {
        $this->value = $value;
        $this->detail = $detail;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'value' => $this->value,
            'detail' => $this->detail,
        ]);
    }
}
