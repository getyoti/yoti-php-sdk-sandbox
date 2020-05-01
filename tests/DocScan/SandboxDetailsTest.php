<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\SandboxDetails;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxDetails
 */
class SandboxDetailsTest extends TestCase
{

    private const SOME_NAME = 'someName';
    private const SOME_VALUE = 'someValue';

    /**
     * @test
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getValue
     */
    public function shouldStoreValuesCorrectly()
    {
        $result = (new SandboxDetails(self::SOME_NAME, self::SOME_VALUE));

        $this->assertEquals(self::SOME_NAME, $result->getName());
        $this->assertEquals(self::SOME_VALUE, $result->getValue());
    }

    /**
     * @test
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJsonCorrectly()
    {
        $result = (new SandboxDetails(self::SOME_NAME, self::SOME_VALUE));

        $expected = [
            'name' => self::SOME_NAME,
            'value' => self::SOME_VALUE,
        ];

        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($result));
    }
}
