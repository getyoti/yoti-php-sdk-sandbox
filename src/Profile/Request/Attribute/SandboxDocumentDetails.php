<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\Attribute;

use Yoti\Profile\Attribute\DocumentDetails;

class SandboxDocumentDetails extends DocumentDetails
{
    public function getValue(): string
    {
        $details = [
            $this->getType(),
            $this->getIssuingCountry(),
            $this->getDocumentNumber(),
        ];

        $expirationDate = $this->getExpirationDate();
        $details[] = (null !== $expirationDate) ? $expirationDate->format('Y-m-d') : '-';

        $issuingAuthority = $this->getIssuingAuthority();
        if (null !== $issuingAuthority) {
            $details[] = $issuingAuthority;
        }

        return implode(' ', $details);
    }
}
