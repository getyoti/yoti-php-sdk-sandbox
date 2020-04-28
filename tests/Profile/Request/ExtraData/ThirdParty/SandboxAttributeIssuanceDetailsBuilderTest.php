<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetailsBuilder;
use Yoti\Sandbox\Test\TestCase;
use Yoti\Util\DateTime;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetailsBuilder
 */
class SandboxAttributeIssuanceDetailsBuilderTest extends TestCase
{
    private const SOME_TOKEN = 'some-token';
    private const SOME_DEFINITION = 'some-definition';
    private const SOME_DATE_STRING = '2020-01-02T01:02:03.123456Z';
    private const TYPE_THIRD_PARTY_ATTRIBUTE = 'THIRD_PARTY_ATTRIBUTE';

    /**
     * @test
     *
     * @covers ::withDefinition
     * @covers ::withExpiryDate
     * @covers ::withIssuanceToken
     * @covers ::build
     * @covers \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetails::__construct
     * @covers \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetails::jsonSerialize
     */
    public function shouldBuildSandboxAttributeIssuanceDetails()
    {
        $someDateTime = DateTime::stringToDateTime(self::SOME_DATE_STRING);

        $sandboxAttributeIssuanceDetails = (new SandboxAttributeIssuanceDetailsBuilder())
            ->withDefinition(self::SOME_DEFINITION)
            ->withExpiryDate($someDateTime)
            ->withIssuanceToken(self::SOME_TOKEN)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'type' => self::TYPE_THIRD_PARTY_ATTRIBUTE,
                'value' => [
                    'issuance_token' => self::SOME_TOKEN,
                    'issuing_attributes' => [
                        'expiry_date' => $someDateTime->format(DateTime::RFC3339),
                        'definitions' => [
                            [
                                'name' => self::SOME_DEFINITION,
                            ],
                        ],
                    ],
                ],
            ]),
            json_encode($sandboxAttributeIssuanceDetails)
        );
    }
}
