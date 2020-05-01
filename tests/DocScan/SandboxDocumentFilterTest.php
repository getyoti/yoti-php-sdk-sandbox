<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\SandboxDocumentFilter
 */
class SandboxDocumentFilterTest extends TestCase
{
    private const SOME_COUNTRY_CODE = 'some-country';
    private const SOME_DOCUMENT_TYPE = 'some-type';

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder::build
     * @covers \Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder::withCountryCode
     * @covers \Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder::withDocumentType
     */
    public function shouldSerializeToJson()
    {
        $filter = (new SandboxDocumentFilterBuilder())
            ->withCountryCode(self::SOME_COUNTRY_CODE)
            ->withDocumentType(self::SOME_DOCUMENT_TYPE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'document_types' => [
                    'some-type'
                ],
                'country_codes'  => [
                    'some-country'
                ]
            ]),
            json_encode($filter)
        );
    }

    /**
     * @test
     *
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder::withCountryCode
     */
    public function shouldSerializeToJsonWithCountryCodeOnly()
    {
        $filter = (new SandboxDocumentFilterBuilder())
            ->withCountryCode(self::SOME_COUNTRY_CODE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'document_types' => [],
                'country_codes'  => [
                    'some-country'
                ]
            ]),
            json_encode($filter)
        );
    }

    /**
     * @test
     *
     * @covers ::jsonSerialize
     * @covers \Yoti\Sandbox\DocScan\SandboxDocumentFilterBuilder::withDocumentType
     */
    public function shouldSerializeToJsonWithDocumentTypeOnly()
    {
        $filter = (new SandboxDocumentFilterBuilder())
            ->withDocumentType(self::SOME_DOCUMENT_TYPE)
            ->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'document_types' => [
                    'some-type'
                ],
                'country_codes'  => []
            ]),
            json_encode($filter)
        );
    }
}
