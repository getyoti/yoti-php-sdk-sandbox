<?php

declare(strict_types=1);

namespace Yoti\Sandbox\DocScan;

use Yoti\Util\Validation;

class SandboxDocumentFilter implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $documentTypes;

    /**
     * @var string[]
     */
    private $countryCodes;

    /**
     * @param string[] $documentTypes
     * @param string[] $countryCodes
     */
    public function __construct(array $documentTypes, array $countryCodes)
    {
        Validation::isArrayOfStrings($documentTypes, 'documentTypes');
        $this->documentTypes = $documentTypes;

        Validation::isArrayOfStrings($countryCodes, 'countryCodes');
        $this->countryCodes = $countryCodes;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'document_types' => $this->documentTypes,
            'country_codes' => $this->countryCodes,
        ];
    }
}
