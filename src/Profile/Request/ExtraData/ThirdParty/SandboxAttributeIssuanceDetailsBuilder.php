<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty;

use Yoti\Util\Validation;

class SandboxAttributeIssuanceDetailsBuilder
{
    /**
     * @var string
     */
    private $issuanceToken;

    /**
     * @var \DateTime
     */
    private $expiryDate;

    /**
     * @var SandboxDefinition[]
     */
    private $definitions;

    /**
     * @param string $issuanceToken
     *
     * @return $this
     */
    public function withIssuanceToken(string $issuanceToken): self
    {
        Validation::notEmptyString($issuanceToken, 'issuanceToken');
        $this->issuanceToken = $issuanceToken;
        return $this;
    }

    /**
     * @param \DateTime $expiryDate
     *
     * @return $this
     */
    public function withExpiryDate(\DateTime $expiryDate): self
    {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    /**
     * @param string $definition
     *
     * @return self
     */
    public function withDefinition(string $definition): self
    {
        Validation::notEmptyString($definition, 'definition');
        $this->definitions[] = new SandboxDefinition($definition);
        return $this;
    }

    /**
     * @return SandboxAttributeIssuanceDetails
     */
    public function build(): SandboxAttributeIssuanceDetails
    {
        $value = new SandboxAttributeIssuanceDetailsValue(
            $this->issuanceToken,
            new SandboxIssuingAttributes($this->expiryDate, $this->definitions)
        );
        return new SandboxAttributeIssuanceDetails($value);
    }
}
