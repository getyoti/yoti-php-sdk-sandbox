<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

class SandboxExpectationBuilder
{

    /**
     * @var SandboxTaskResults
     */
    private $taskResults;

    /**
     * @var SandboxCheckReports
     */
    private $checkReports;

    /**
     * @param SandboxTaskResults $taskResults
     * @return $this
     */
    public function withTaskResults(SandboxTaskResults $taskResults): self
    {
        $this->taskResults = $taskResults;
        return $this;
    }

    /**
     * @param SandboxCheckReports $checkReports
     * @return $this
     */
    public function withCheckReports(SandboxCheckReports $checkReports): self
    {
        $this->checkReports = $checkReports;
        return $this;
    }

    /**
     * @return SandboxExpectation
     */
    public function build(): SandboxExpectation
    {
        return new SandboxExpectation($this->taskResults, $this->checkReports);
    }
}
