<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\SandboxDataEntry;
use Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraDataBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraDataBuilder
 */
class SandboxExtraDataBuilderTest extends TestCase
{
    /**
     * @test
     *
     * @covers ::build
     * @covers ::withDataEntry
     * @covers \Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraData::__construct
     * @covers \Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraData::jsonSerialize
     */
    public function shouldBuildSandboxExtraData()
    {
        $dataEntryMock = $this->createMock(SandboxDataEntry::class);
        $dataEntryMock->method('jsonSerialize')->willReturn((object) ['some' => 'data-entry']);

        $extraData = (new SandboxExtraDataBuilder())
            ->withDataEntry($dataEntryMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'data_entry' => [$dataEntryMock]
            ]),
            json_encode($extraData),
        );
    }
}
