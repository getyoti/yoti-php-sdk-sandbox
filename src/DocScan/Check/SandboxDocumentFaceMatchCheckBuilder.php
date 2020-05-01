<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxDocumentFaceMatchCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @return SandboxDocumentFaceMatchCheck
     */
    public function build(): SandboxDocumentFaceMatchCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxDocumentFaceMatchCheck($result, $this->documentFilter);
    }
}
