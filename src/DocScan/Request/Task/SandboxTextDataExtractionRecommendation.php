<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

use Yoti\Util\Json;

class SandboxTextDataExtractionRecommendation implements \JsonSerializable
{
    /**
     * @var string
     */
    private $value;

    /**
     * @var SandboxTextDataExtractionReason|null
     */
    private $reason;

    /**
     * @param string $value
     * @param SandboxTextDataExtractionReason|null $reason
     */
    public function __construct(
        string $value,
        ?SandboxTextDataExtractionReason $reason
    ) {
        $this->value = $value;
        $this->reason = $reason;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'value' => $this->value,
            'reason' => $this->reason,
        ]);
    }
}
