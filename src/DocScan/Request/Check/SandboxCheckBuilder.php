<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxBreakdown;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxCheckReport;
use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendation;

abstract class SandboxCheckBuilder
{

    /**
     * @var SandboxRecommendation
     */
    protected $recommendationResponse;

    /**
     * @var SandboxBreakdown[]
     */
    protected $breakdownResponse = [];

    /**
     * @param SandboxRecommendation $recommendationResponse
     * @return $this
     */
    public function withRecommendation(SandboxRecommendation $recommendationResponse): self
    {
        $this->recommendationResponse = $recommendationResponse;
        return $this;
    }

    /**
     * @param SandboxBreakdown $breakdownResponse
     * @return $this
     */
    public function withBreakdown(SandboxBreakdown $breakdownResponse): self
    {
        $this->breakdownResponse[] = $breakdownResponse;
        return $this;
    }

    /**
     * @param SandboxBreakdown[] $breakdowns
     * @return $this
     */
    public function withBreakdowns(array $breakdowns): self
    {
        $this->breakdownResponse = $breakdowns;
        return $this;
    }

    /**
     * @return SandboxCheckReport
     */
    protected function buildReport(): SandboxCheckReport
    {
        return new SandboxCheckReport($this->recommendationResponse, $this->breakdownResponse);
    }

    /**
     * @return SandboxCheck
     */
    abstract public function build(): SandboxCheck;
}
