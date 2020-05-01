<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

use Yoti\Util\Validation;

class SandboxBreakdownBuilder
{

    private const PASS = "PASS";
    private const FAIL = "FAIL";

    /**
     * @var string
     */
    private $subCheck;

    /**
     * @var string
     */
    private $result;

    /**
     * @var SandboxDetails[]
     */
    private $details = [];

    /**
     * @param string $check
     * @return SandboxBreakdown
     */
    public static function passForCheck(string $check)
    {
        return new SandboxBreakdown($check, self::PASS, []);
    }

    /**
     * @param string $check
     * @return SandboxBreakdown
     */
    public static function failForCheck(string $check)
    {
        return new SandboxBreakdown($check, self::FAIL, []);
    }

    /**
     * @param string $subCheck
     * @return $this
     */
    public function withSubCheck(string $subCheck): self
    {
        $this->subCheck = $subCheck;
        return $this;
    }

    /**
     * @param string $result
     * @return $this
     */
    public function withResult(string $result): self
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function withDetail(string $name, string $value): self
    {
        $this->details[] = new SandboxDetails($name, $value);
        return $this;
    }

    /**
     * @param SandboxDetails[] $details
     * @return $this
     */
    public function withDetails(array $details): self
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return SandboxBreakdown
     */
    public function build(): SandboxBreakdown
    {
        Validation::notEmptyString($this->subCheck, "subCheck");
        Validation::notEmptyString($this->result, "result");

        return new SandboxBreakdown($this->subCheck, $this->result, $this->details);
    }
}
