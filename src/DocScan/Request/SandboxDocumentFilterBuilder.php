<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan\Request;

class SandboxDocumentFilterBuilder
{
    /**
     * @var string[]
     */
    private $documentTypes = [];

    /**
     * @var string[]
     */
    private $countryCodes = [];

    /**
     * @param string $documentType
     *
     * @return self
     */
    public function withDocumentType(string $documentType): self
    {
        $this->documentTypes[] = $documentType;
        return $this;
    }

    /**
     * @param string $countryCode
     *
     * @return self
     */
    public function withCountryCode(string $countryCode): self
    {
        $this->countryCodes[] = $countryCode;
        return $this;
    }

    /**
     * @return SandboxDocumentFilter
     */
    public function build(): SandboxDocumentFilter
    {
        return new SandboxDocumentFilter($this->documentTypes, $this->countryCodes);
    }
}
