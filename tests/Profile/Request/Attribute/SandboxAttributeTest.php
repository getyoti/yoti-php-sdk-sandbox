<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\Attribute;

use Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute
 */
class SandboxAttributeTest extends TestCase
{
    private const SOME_NAME = 'some-name';
    private const SOME_VALUE = 'some-value';

    /**
     * @var SandboxAnchor
     */
    private $mockAnchor;

    public function setup(): void
    {
        $this->mockAnchor = $this->createMock(SandboxAnchor::class);
        $this->mockAnchor
            ->method('jsonSerialize')
            ->willReturn(['some' => 'anchor']);
    }

    /**
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerialize()
    {
        $attribute = new SandboxAttribute(
            self::SOME_NAME,
            self::SOME_VALUE,
            ''
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => self::SOME_NAME,
                'value' => self::SOME_VALUE,
                'derivation' => '',
                'anchors' => [],
            ]),
            json_encode($attribute)
        );
    }

    /**
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerializeWithAnchor()
    {
        $attribute = new SandboxAttribute(
            self::SOME_NAME,
            self::SOME_VALUE,
            '',
            [$this->mockAnchor]
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => self::SOME_NAME,
                'value' => self::SOME_VALUE,
                'derivation' => '',
                'anchors' => [$this->mockAnchor],
            ]),
            json_encode($attribute)
        );
    }

    /**
     * @group legacy
     *
     * phpcs:disable
     * @expectedDeprecation Boolean argument 4 passed to Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute::__construct is deprecated in 1.1.0 and will be removed in 2.0.0
     * phpcs:enable
     *
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerializeWithOptional()
    {
        $attribute = new SandboxAttribute(
            self::SOME_NAME,
            self::SOME_VALUE,
            '',
            true
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => self::SOME_NAME,
                'value' => self::SOME_VALUE,
                'derivation' => '',
                'anchors' => [],
            ]),
            json_encode($attribute)
        );
    }

    /**
     * @group legacy
     *
     * phpcs:disable
     * @expectedDeprecation Boolean argument 4 passed to Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute::__construct is deprecated in 1.1.0 and will be removed in 2.0.0
     * phpcs:enable
     *
     * @covers ::jsonSerialize
     * @covers ::__construct
     */
    public function testJsonSerializeWithOptionalAndAnchor()
    {
        $attribute = new SandboxAttribute(
            self::SOME_NAME,
            self::SOME_VALUE,
            '',
            true,
            [$this->mockAnchor]
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'name' => self::SOME_NAME,
                'value' => self::SOME_VALUE,
                'derivation' => '',
                'anchors' => [$this->mockAnchor],
            ]),
            json_encode($attribute)
        );
    }
}
