<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxZoomLivenessCheckBuilder extends SandboxCheckBuilder
{
    /**
     * @return SandboxZoomLivenessCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxZoomLivenessCheck($result);
    }
}
