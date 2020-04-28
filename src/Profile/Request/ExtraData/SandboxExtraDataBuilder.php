<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData;

class SandboxExtraDataBuilder
{
    /**
     * @var SandboxDataEntry[]
     */
    private $dataEntries = [];

    /**
     * @param SandboxDataEntry $dataEntry
     *
     * @return $this
     */
    public function withDataEntry($dataEntry): self
    {
        $this->dataEntries[] = $dataEntry;
        return $this;
    }

    /**
     * @return SandboxExtraData
     */
    public function build(): SandboxExtraData
    {
        return new SandboxExtraData($this->dataEntries);
    }
}
