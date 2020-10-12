<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Task;

class SandboxTextDataExtractionReasonBuilder
{
    private const VALUE_QUALITY = "QUALITY";
    private const VALUE_USER_ERROR = "USER_ERROR";

    /**
     * @var string
     */
    private $value;

    /**
     * @var string|null
     */
    private $detail;

    /**
     * @return $this
     */
    public function forQuality(): self
    {
        $this->value = self::VALUE_QUALITY;
        return $this;
    }

    /**
     * @return $this
     */
    public function forUserError(): self
    {
        $this->value = self::VALUE_USER_ERROR;
        return $this;
    }

    /**
     * @param string $detail
     *
     * @return $this
     */
    public function withDetail(string $detail): self
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * @return SandboxTextDataExtractionReason
     */
    public function build(): SandboxTextDataExtractionReason
    {
        return new SandboxTextDataExtractionReason(
            $this->value,
            $this->detail
        );
    }
}
