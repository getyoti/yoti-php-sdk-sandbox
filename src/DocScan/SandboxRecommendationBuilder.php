<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

class SandboxRecommendationBuilder
{

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $reason;

    /**
     * @var string
     */
    private $recoverySuggestion;

    /**
     * @param string $value
     * @return $this
     */
    public function withValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param string $reason
     * @return $this
     */
    public function withReason(string $reason): self
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @param string $recoverySuggestion
     * @return $this
     */
    public function withRecoverySuggestion(string $recoverySuggestion): self
    {
        $this->recoverySuggestion = $recoverySuggestion;
        return $this;
    }

    /**
     * @return SandboxRecommendation
     */
    public function build(): SandboxRecommendation
    {
        return new SandboxRecommendation($this->value, $this->reason, $this->recoverySuggestion);
    }
}
