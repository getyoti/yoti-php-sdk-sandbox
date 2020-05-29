<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxDefinition;
use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxIssuingAttributes;
use Yoti\Sandbox\Test\TestCase;
use Yoti\Util\DateTime;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxIssuingAttributes
 */
class SandboxIssuingAttributesTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     *
     * @dataProvider expiryDateDataProvider
     */
    public function shouldSerializeToJson($inputDate, $outputDate)
    {
        $definitionMock = $this->createMock(SandboxDefinition::class);
        $definitionMock
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'definition']);

        $someDateTime = DateTime::stringToDateTime($inputDate);

        $sandboxIssuingAttributes = new SandboxIssuingAttributes(
            $someDateTime,
            [$definitionMock]
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'expiry_date' => $outputDate,
                'definitions' => [$definitionMock],
            ]),
            json_encode($sandboxIssuingAttributes)
        );
    }

    /**
     * Provides test expiry dates.
     */
    public function expiryDateDataProvider()
    {
        return [
            ['2020-01-02T01:02:03.123456Z', '2020-01-02T01:02:03.123+00:00'],
            ['2020-01-01T01:02:03.123+04:00', '2019-12-31T21:02:03.123+00:00'],
            ['2020-01-02T01:02:03.123-02:00', '2020-01-02T03:02:03.123+00:00']
        ];
    }
}
