<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty;

class SandboxAttributeIssuanceDetailsValue implements \JsonSerializable
{
    /**
     * @var string
     */
    private $issuanceToken;

    /**
     * @var SandboxIssuingAttributes
     */
    private $issuingAttributes;

    /**
     * @param string $issuanceToken
     * @param SandboxIssuingAttributes $issuingAttributes
     */
    public function __construct(string $issuanceToken, SandboxIssuingAttributes $issuingAttributes)
    {
        $this->issuanceToken = $issuanceToken;
        $this->issuingAttributes = $issuingAttributes;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'issuance_token' => $this->issuanceToken,
            'issuing_attributes' => $this->issuingAttributes,
        ];
    }
}
