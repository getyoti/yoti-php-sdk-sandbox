<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty;

use Yoti\Util\DateTime;
use Yoti\Util\Validation;

class SandboxIssuingAttributes implements \JsonSerializable
{
    /**
     * @var \DateTime
     */
    private $expiryDate;

    /**
     * @var SandboxDefinition[]
     */
    private $definitions;

    /**
     * @param \DateTime $expiryDate
     * @param SandboxDefinition[] $definitions
     */
    public function __construct(\DateTime $expiryDate, array $definitions)
    {
        $this->expiryDate = $expiryDate;

        Validation::isArrayOfType($definitions, [SandboxDefinition::class], 'definitions');
        $this->definitions = $definitions;
    }

    /**
     * @return \stdClass
     */
    public function jsonSerialize(): \stdClass
    {
        return (object) [
            'expiry_date' => $this->expiryDate->format(DateTime::RFC3339),
            'definitions' => $this->definitions,
        ];
    }
}
