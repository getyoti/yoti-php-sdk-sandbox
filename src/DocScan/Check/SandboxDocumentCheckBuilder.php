<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

use Yoti\Sandbox\DocScan\SandboxDocumentFilter;

abstract class SandboxDocumentCheckBuilder extends SandboxCheckBuilder
{
    /**
     * @var SandboxDocumentFilter
     */
    protected $documentFilter;

    /**
     * @param SandboxDocumentFilter $documentFilter
     *
     * @return $this
     */
    public function withDocumentFilter(SandboxDocumentFilter $documentFilter): self
    {
        $this->documentFilter = $documentFilter;
        return $this;
    }
}
