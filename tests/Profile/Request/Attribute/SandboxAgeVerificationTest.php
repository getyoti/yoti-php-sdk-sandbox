<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\Attribute;

use Yoti\Profile\UserProfile;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification
 */
class SandboxAgeVerificationTest extends TestCase
{
    private const SOME_TIMESTAMP = 1171502725;
    private const SOME_TIMESTAMP_DATE_STRING = '2007-02-15';
    private const SOME_DERIVATION = 'age_under:18';

    /**
     * @var SandboxAgeVerification
     */
    private $ageVerification;

    public function setup(): void
    {
        $this->ageVerification = new SandboxAgeVerification(
            (new \DateTime())->setTimestamp(self::SOME_TIMESTAMP),
            self::SOME_DERIVATION
        );
    }

    /**
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerialize()
    {
        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => self::SOME_DERIVATION,
                'anchors' => [],
            ]),
            json_encode($this->ageVerification)
        );
    }

    /**
     * @covers ::forAgeOver
     * @covers ::__construct
     */
    public function testForAgeOver()
    {
        $ageOverVerification = SandboxAgeVerification::forAgeOver(
            20,
            new \DateTime(self::SOME_TIMESTAMP_DATE_STRING)
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => 'age_over:20',
                'anchors' => [],
            ]),
            json_encode($ageOverVerification)
        );
    }

    /**
     * @covers ::forAgeUnder
     * @covers ::__construct
     */
    public function testForAgeUnder()
    {
        $ageUnderVerification = SandboxAgeVerification::forAgeUnder(
            30,
            new \DateTime(self::SOME_TIMESTAMP_DATE_STRING)
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => UserProfile::ATTR_DATE_OF_BIRTH,
                'value' => self::SOME_TIMESTAMP_DATE_STRING,
                'derivation' => 'age_under:30',
                'anchors' => [],
            ]),
            json_encode($ageUnderVerification)
        );
    }
}
