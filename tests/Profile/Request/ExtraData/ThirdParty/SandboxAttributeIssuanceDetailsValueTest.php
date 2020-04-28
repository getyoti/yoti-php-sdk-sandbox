<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetailsValue;
use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxIssuingAttributes;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetailsValue
 */
class SandboxAttributeIssuanceDetailsValueTest extends TestCase
{
    private const SOME_TOKEN = 'some-token';

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJson()
    {
        $issuingAttributesMock = $this->createMock(SandboxIssuingAttributes::class);
        $issuingAttributesMock
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'issuing-attributes']);

        $value = new SandboxAttributeIssuanceDetailsValue(self::SOME_TOKEN, $issuingAttributesMock);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'issuance_token' => self::SOME_TOKEN,
                'issuing_attributes' => $issuingAttributesMock,
            ]),
            json_encode($value)
        );
    }
}
