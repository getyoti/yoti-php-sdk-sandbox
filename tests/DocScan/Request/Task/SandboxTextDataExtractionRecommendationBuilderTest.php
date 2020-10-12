<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionReason;
use Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendationBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendationBuilder
 */
class SandboxTextDataExtractionRecommendationBuilderTest extends TestCase
{
    private const VALUE_PROGRESS = "PROGRESS";
    private const VALUE_SHOULD_TRY_AGAIN = "SHOULD_TRY_AGAIN";
    private const VALUE_MUST_TRY_AGAIN = "MUST_TRY_AGAIN";

    /**
     * @test
     * @covers ::withReason
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::jsonSerialize
     */
    public function shouldBuildWithReason(): void
    {
        $someReasonMock = $this->createMock(SandboxTextDataExtractionReason::class);
        $someReasonMock
            ->method('jsonSerialize')
            ->willReturn((object) ['some' => 'reason']);

        $result = (new SandboxTextDataExtractionRecommendationBuilder())
            ->forMustTryAgain()
            ->withReason($someReasonMock)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_MUST_TRY_AGAIN,
                'reason' => $someReasonMock,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::forProgress
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::jsonSerialize
     */
    public function shouldBuildForProgress(): void
    {
        $result = (new SandboxTextDataExtractionRecommendationBuilder())
            ->forProgress()
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_PROGRESS,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::forMustTryAgain
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::jsonSerialize
     */
    public function shouldBuildForMustTryAgain(): void
    {
        $result = (new SandboxTextDataExtractionRecommendationBuilder())
            ->forMustTryAgain()
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_MUST_TRY_AGAIN,
            ]),
            json_encode($result)
        );
    }

    /**
     * @test
     * @covers ::forShouldTryAgain
     * @covers ::build
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::__construct
     * @covers \Yoti\Sandbox\DocScan\Request\Task\SandboxTextDataExtractionRecommendation::jsonSerialize
     */
    public function shouldBuildForShouldTryAgain(): void
    {
        $result = (new SandboxTextDataExtractionRecommendationBuilder())
            ->forShouldTryAgain()
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::VALUE_SHOULD_TRY_AGAIN,
            ]),
            json_encode($result)
        );
    }
}
