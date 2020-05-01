<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxLivenessCheck extends SandboxCheck
{
    /**
     * @var string
     */
    private $livenessType;

    /**
     * @param SandboxCheckResult $result
     * @param string $livenessType
     */
    public function __construct(SandboxCheckResult $result, string $livenessType)
    {
        parent::__construct($result);

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
