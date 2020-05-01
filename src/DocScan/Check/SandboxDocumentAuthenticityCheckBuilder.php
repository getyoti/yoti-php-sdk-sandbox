<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxDocumentAuthenticityCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @return SandboxDocumentAuthenticityCheck
     */
    public function build(): SandboxDocumentAuthenticityCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxDocumentAuthenticityCheck($result, $this->documentFilter);
    }
}
