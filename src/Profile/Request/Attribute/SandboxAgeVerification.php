<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\Attribute;

use Yoti\Profile\UserProfile;

class SandboxAgeVerification extends SandboxAttribute
{
    private const AGE_OVER_FORMAT = 'age_over:%d';
    private const AGE_UNDER_FORMAT = 'age_under:%d';

    /**
     * @param \DateTime $date
     * @param string $derivation
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     */
    final public function __construct(\DateTime $date, string $derivation = '', array $anchors = [])
    {
        parent::__construct(
            UserProfile::ATTR_DATE_OF_BIRTH,
            $date->format('Y-m-d'),
            $derivation,
            true,
            $anchors
        );
    }

    /**
     * @param int $age
     * @param \DateTime $date
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     */
    public static function forAgeOver(int $age, \DateTime $date, array $anchors = []): self
    {
        return new static($date, sprintf(self::AGE_OVER_FORMAT, $age), $anchors);
    }

    /**
     * @param int $age
     * @param \DateTime $date
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     */
    public static function forAgeUnder(int $age, \DateTime $date, array $anchors = []): self
    {
        return new static($date, sprintf(self::AGE_UNDER_FORMAT, $age), $anchors);
    }
}
