<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReasonBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReasonBuilder
 */
class SandboxTextDataExtractionReasonBuilderTest extends TestCase
{
    private const VALUE_QUALITY = "QUALITY";
    private const VALUE_USER_ERROR = "USER_ERROR";
    private const SOME_DETAIL = "some-detail";

    /**
     * @test
     * @covers ::forQuality
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::jsonSerialize
     */
    public function shouldBuildForQuality(): void
    {
        $result = (new SandboxTextDataExtractionReasonBuilder())
            ->forQuality()
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_QUALITY,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::forUserError
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::jsonSerialize
     */
    public function shouldBuildForUserError(): void
    {
        $result = (new SandboxTextDataExtractionReasonBuilder())
            ->forUserError()
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_USER_ERROR,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::withDetail
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason::jsonSerialize
     */
    public function shouldBuildWithDetail(): void
    {
        $result = (new SandboxTextDataExtractionReasonBuilder())
            ->forUserError()
            ->withDetail(self::SOME_DETAIL)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_USER_ERROR,
                'detail' => self::SOME_DETAIL,
            ]),
            json_encode($result)
        );
    }
}
