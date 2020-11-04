<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxTextDataExtractionRecommendationBuilder
{
    private const VALUE_PROGRESS = "PROGRESS";
    private const VALUE_SHOULD_TRY_AGAIN = "SHOULD_TRY_AGAIN";
    private const VALUE_MUST_TRY_AGAIN = "MUST_TRY_AGAIN";

    /**
     * @var string
     */
    private $value;

    /**
     * @var SandboxTextDataExtractionReason
     */
    private $reason;

    /**
     * @return $this
     */
    public function forProgress(): self
    {
        $this->value = self::VALUE_PROGRESS;
        return $this;
    }

    /**
     * @return $this
     */
    public function forShouldTryAgain(): self
    {
        $this->value = self::VALUE_SHOULD_TRY_AGAIN;
        return $this;
    }

    /**
     * @return $this
     */
    public function forMustTryAgain(): self
    {
        $this->value = self::VALUE_MUST_TRY_AGAIN;
        return $this;
    }

    /**
     * @param SandboxTextDataExtractionReason $reason
     *
     * @return $this
     */
    public function withReason(SandboxTextDataExtractionReason $reason): self
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return SandboxTextDataExtractionRecommendation
     */
    public function build(): SandboxTextDataExtractionRecommendation
    {
        return new SandboxTextDataExtractionRecommendation(
            $this->value,
            $this->reason
        );
    }
}
