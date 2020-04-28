<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData;

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
