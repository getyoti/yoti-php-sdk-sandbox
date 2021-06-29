<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxThirdPartyIdentityCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @return SandboxThirdPartyIdentityCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxThirdPartyIdentityCheck($result, $this->documentFilter);
    }
}
