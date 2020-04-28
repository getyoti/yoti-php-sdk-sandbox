<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\SandboxDataEntry;

class SandboxAttributeIssuanceDetails extends SandboxDataEntry
{
    private const TYPE = 'THIRD_PARTY_ATTRIBUTE';

    /**
     * @param SandboxAttributeIssuanceDetailsValue $value
     */
    public function __construct(SandboxAttributeIssuanceDetailsValue $value)
    {
        parent::__construct(self::TYPE, $value);
    }
}
