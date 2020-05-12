<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxCheckResult implements \JsonSerializable
{

    /**
     * @var SandboxCheckReport
     */
    private $report;

    /**
     * @param SandboxCheckReport $report
     */
    public function __construct(SandboxCheckReport $report)
    {
        $this->report = $report;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'report' => $this->report,
        ];
    }
}
