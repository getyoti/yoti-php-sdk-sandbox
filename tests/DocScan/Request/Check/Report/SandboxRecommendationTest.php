<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Check\Report;

use Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendation
 */
class SandboxRecommendationTest extends TestCase
{

    private const SOME_VALUE = 'someValue';
    private const SOME_REASON = 'someReason';
    private const SOME_RECOVERY_SUGGESTION = 'someRecoverySuggestion';

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder::withValue
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder::withReason
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder::withRecoverySuggestion
     * @covers \Yoti\Sandbox\DocScan\Request\Check\Report\SandboxRecommendationBuilder::build
     */
    public function shouldBuildCorrectly()
    {
        $result = (new SandboxRecommendationBuilder())
            ->withValue(self::SOME_VALUE)
            ->withReason(self::SOME_REASON)
            ->withRecoverySuggestion(self::SOME_RECOVERY_SUGGESTION)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'value' => self::SOME_VALUE,
                'reason' => self::SOME_REASON,
                'recovery_suggestion' => self::SOME_RECOVERY_SUGGESTION,
            ]),
            json_encode($result)
        );
    }
}
