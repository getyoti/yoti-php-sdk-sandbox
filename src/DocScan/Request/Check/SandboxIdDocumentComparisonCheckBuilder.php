<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

use Yoti\Sandbox\DocScan\Request\SandboxDocumentFilter;

class SandboxIdDocumentComparisonCheckBuilder extends SandboxCheckBuilder
{
    /**
     * @var SandboxDocumentFilter
     */
    private $secondaryDocumentFilter;

    /**
     * @param SandboxDocumentFilter $secondaryDocumentFilter
     *
     * @return $this
     */
    public function withSecondaryDocumentFilter(SandboxDocumentFilter $secondaryDocumentFilter): self
    {
        $this->secondaryDocumentFilter = $secondaryDocumentFilter;
        return $this;
    }

    /**
     * @return SandboxIdDocumentComparisonCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxIdDocumentComparisonCheck($result, $this->secondaryDocumentFilter);
    }
}
