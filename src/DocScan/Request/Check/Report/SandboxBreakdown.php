<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check\Report;

use Yoti\Util\Json;
use Yoti\Util\Validation;

class SandboxBreakdown implements \JsonSerializable
{

    /**
     * @var string
     */
    private $subCheck;

    /**
     * @var string
     */
    private $result;

    /**
     * @var array<string, mixed>
     */
    private $details;

    /**
     * SandboxBreakdown constructor.
     * @param string $subCheck
     * @param string $result
     * @param SandboxDetail[] $details
     */
    public function __construct(string $subCheck, string $result, array $details)
    {
        $this->subCheck = $subCheck;
        $this->result = $result;

        Validation::isArrayOfType($details, [SandboxDetail::class], 'details');
        $this->details = $details;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) Json::withoutNullValues([
            'sub_check' => $this->subCheck,
            'result' => $this->result,
            'details' => $this->details,
        ]);
    }
}
