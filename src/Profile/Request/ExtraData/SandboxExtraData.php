<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData;

use Yoti\Util\Validation;

class SandboxExtraData implements \JsonSerializable
{
    /**
     * @var SandboxDataEntry[]
     */
    private $dataEntries;

    /**
     * @param SandboxDataEntry[] $dataEntries
     */
    public function __construct(array $dataEntries)
    {
        Validation::isArrayOfType($dataEntries, [SandboxDataEntry::class], 'dataEntries');
        $this->dataEntries = $dataEntries;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'data_entry' => $this->dataEntries,
        ];
    }
}
