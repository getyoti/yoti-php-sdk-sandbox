<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request\Check;

class SandboxDocumentFaceMatchCheckBuilder extends SandboxDocumentCheckBuilder
{

    /**
     * @return SandboxDocumentFaceMatchCheck
     */
    public function build(): SandboxCheck
    {
        $result = new SandboxCheckResult($this->buildReport());
        return new SandboxDocumentFaceMatchCheck($result, $this->documentFilter);
    }
}
