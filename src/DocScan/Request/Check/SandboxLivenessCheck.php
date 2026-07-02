<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxLivenessCheck extends SandboxCheck
{
    /**
     * @var string
     */
    private $livenessType;

    /**
     * @param SandboxCheckResult $result
     * @param string $livenessType
     * @param int|null $handledCheckLimit
     */
    public function __construct(SandboxCheckResult $result, string $livenessType, ?int $handledCheckLimit = null)
    {
        parent::__construct($result, $handledCheckLimit);

        $this->livenessType = $livenessType;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $jsonData = parent::jsonSerialize();
        $jsonData->liveness_type = $this->livenessType;
        return $jsonData;
    }
}
