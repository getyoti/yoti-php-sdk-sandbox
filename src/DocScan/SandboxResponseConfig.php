<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

use Yoti\Util\Json;

class SandboxResponseConfig implements \JsonSerializable
{

    /**
     * @var SandboxTaskResults|null
     */
    private $taskResults;

    /**
     * @var SandboxCheckReports
     */
    private $checkReports;

    /**
     * @param SandboxTaskResults|null $taskResults
     * @param SandboxCheckReports $checkReports
     */
    public function __construct(?SandboxTaskResults $taskResults, SandboxCheckReports $checkReports)
    {
        $this->taskResults = $taskResults;
        $this->checkReports = $checkReports;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'task_results' => $this->taskResults,
            'check_reports' => $this->checkReports,
        ]);
    }
}
