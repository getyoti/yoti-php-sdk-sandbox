<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxCheck implements \JsonSerializable
{

    /**
     * @var SandboxCheckResult
     */
    private $result;

    /**
     * @param SandboxCheckResult $result
     */
    public function __construct(SandboxCheckResult $result)
    {
        $this->result = $result;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'result' => $this->result,
        ];
    }
}
