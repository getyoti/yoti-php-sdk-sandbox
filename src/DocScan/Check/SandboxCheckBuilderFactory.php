<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Check;

class SandboxCheckBuilderFactory
{

    /**
     * @return SandboxDocumentAuthenticityCheckBuilder
     */
    public function createDocumentAuthenticityCheckBuilder(): SandboxDocumentAuthenticityCheckBuilder
    {
        return new SandboxDocumentAuthenticityCheckBuilder();
    }

    /**
     * @return SandboxDocumentFaceMatchCheckBuilder
     */
    public function createDocumentFaceMatchCheckBuilder(): SandboxDocumentFaceMatchCheckBuilder
    {
        return new SandboxDocumentFaceMatchCheckBuilder();
    }

    /**
     * @return SandboxDocumentTextDataCheckBuilder
     */
    public function createDocumentTextDataCheckBuilder(): SandboxDocumentTextDataCheckBuilder
    {
        return new SandboxDocumentTextDataCheckBuilder();
    }

    /**
     * @return SandboxZoomLivenessCheckBuilder
     */
    public function createZoomLivenessCheckBuilder(): SandboxZoomLivenessCheckBuilder
    {
        return new SandboxZoomLivenessCheckBuilder();
    }
}
