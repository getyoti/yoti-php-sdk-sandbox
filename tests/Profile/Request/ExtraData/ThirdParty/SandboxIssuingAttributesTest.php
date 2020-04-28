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
    private const SOME_DATE_STRING = '2020-01-02T01:02:03.123456Z';

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJson()
    {
        $definitionMock = $this->createMock(SandboxDefinition::class);
        $definitionMock
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'definition']);

        $someDateTime = DateTime::stringToDateTime(self::SOME_DATE_STRING);

        $sandboxIssuingAttributes = new SandboxIssuingAttributes(
            $someDateTime,
            [$definitionMock]
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'expiry_date' => $someDateTime->format(DateTime::RFC3339),
                'definitions' => [$definitionMock],
            ]),
            json_encode($sandboxIssuingAttributes)
        );
    }
}
