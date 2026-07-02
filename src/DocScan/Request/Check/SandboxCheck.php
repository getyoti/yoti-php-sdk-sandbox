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
     * @var int|null
     */
    private $handledCheckLimit;

    /**
     * @param SandboxCheckResult $result
     * @param int|null $handledCheckLimit
     */
    public function __construct(SandboxCheckResult $result, ?int $handledCheckLimit = null)
    {
        $this->result = $result;
        $this->handledCheckLimit = $handledCheckLimit;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        $data = (object) [
            'result' => $this->result,
        ];

        if (isset($this->handledCheckLimit)) {
            $data->handled_check_limit = $this->handledCheckLimit;
        }

        return $data;
    }
}
