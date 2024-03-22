<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxStaticLivenessCheck extends SandboxLivenessCheck
{
    private const STATIC = 'STATIC';

    /**
     * @param SandboxCheckResult $result
     */
    public function __construct(SandboxCheckResult $result)
    {
        parent::__construct($result, self::STATIC);
    }
}
