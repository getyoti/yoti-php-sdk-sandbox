<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxDocumentAuthenticityCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @return SandboxDocumentAuthenticityCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxDocumentAuthenticityCheck($result, $this->documentFilter);
    }
}
