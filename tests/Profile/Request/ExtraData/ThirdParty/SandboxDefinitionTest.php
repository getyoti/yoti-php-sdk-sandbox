<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\ExtraData\ThirdParty;

use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxDefinition;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxDefinition
 */
class SandboxDefinitionTest extends TestCase
{
    private const SOME_NAME = 'some-name';

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJson()
    {
        $definition = new SandboxDefinition(self::SOME_NAME);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => self::SOME_NAME,
            ]),
            json_encode($definition)
        );
    }
}
