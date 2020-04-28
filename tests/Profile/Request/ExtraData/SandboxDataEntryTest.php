<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\SandboxDataEntry;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\SandboxDataEntry
 */
class SandboxDataEntryTest extends TestCase
{
    private const SOME_TYPE = 'some-type';

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJson()
    {
        $valueMock = $this->createMock(\JsonSerializable::class);
        $valueMock->method('jsonSerialize')->willReturn('some-value');

        $sandboxDataEntry = $this->getMockBuilder(SandboxDataEntry::class)
            ->setConstructorArgs([self::SOME_TYPE, $valueMock])
            ->setMethodsExcept(['jsonSerialize'])
            ->getMock();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'type' => self::SOME_TYPE,
                'value' => $valueMock,
            ]),
            json_encode($sandboxDataEntry)
        );
    }
}
