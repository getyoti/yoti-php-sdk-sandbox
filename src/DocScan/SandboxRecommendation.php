<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

use Yoti\Util\Json;

class SandboxRecommendation implements \JsonSerializable
{

    /**
     * @var string|null
     */
    private $value;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @var string|null
     */
    private $recoverySuggestion;

    /**
     * SandboxRecommendation constructor.
     * @param string|null $value
     * @param string|null $reason
     * @param string|null $recoverySuggestion
     */
    public function __construct(?string $value, ?string $reason, ?string $recoverySuggestion)
    {
        $this->value = $value;
        $this->reason = $reason;
        $this->recoverySuggestion = $recoverySuggestion;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'value' => $this->value,
            'reason' => $this->reason,
            'recovery_suggestion' => $this->recoverySuggestion,
        ]);
    }
}
