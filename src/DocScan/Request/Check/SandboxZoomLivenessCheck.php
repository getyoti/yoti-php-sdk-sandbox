<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxZoomLivenessCheck extends SandboxLivenessCheck
{
    private const ZOOM = 'ZOOM';

    /**
     * @param SandboxCheckResult $result
     * @param int|null $handledCheckLimit
     */
    public function __construct(SandboxCheckResult $result, ?int $handledCheckLimit = null)
    {
        parent::__construct($result, self::ZOOM, $handledCheckLimit);
    }
}
