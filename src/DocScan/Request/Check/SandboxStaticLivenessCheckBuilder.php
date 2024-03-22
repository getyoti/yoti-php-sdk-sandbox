<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxStaticLivenessCheckBuilder extends SandboxCheckBuilder
{
    /**
     * @return SandboxStaticLivenessCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxStaticLivenessCheck($result);
    }
}
