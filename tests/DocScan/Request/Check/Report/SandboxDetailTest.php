<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check\Report;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxDetail;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxDetail
 */
class SandboxDetailTest extends TestCase
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
        $result = (new SandboxDetail(self::SOME_NAME, self::SOME_VALUE));

        $this->assertEquals(self::SOME_NAME, $result->getName());
        $this->assertEquals(self::SOME_VALUE, $result->getValue());
    }

    /**
     * @test
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJsonCorrectly()
    {
        $result = (new SandboxDetail(self::SOME_NAME, self::SOME_VALUE));

        $expected = [
            'name' => self::SOME_NAME,
            'value' => self::SOME_VALUE,
        ];

        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($result));
    }
}
