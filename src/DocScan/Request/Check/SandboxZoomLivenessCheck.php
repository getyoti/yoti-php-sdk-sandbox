<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxZoomLivenessCheck extends SandboxLivenessCheck
{
    private const ZOOM = 'ZOOM';

    /**
     * @param SandboxCheckResult $result
     */
    public function __construct(SandboxCheckResult $result)
    {
        parent::__construct($result, self::ZOOM);
    }
}
