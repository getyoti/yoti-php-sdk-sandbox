<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request;

use Symfony\Bridge\PhpUnit\ExpectDeprecationTrait;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentDetails;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImages;
use Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraData;
use Yoti\Sandbox\Profile\Request\TokenRequest;
use Yoti\Sandbox\Profile\Request\TokenRequestBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\TokenRequestBuilder
 */
class TokenRequestBuilderTest extends TestCase
{
    use ExpectDeprecationTrait;

    private const SOME_REMEMBER_ME_ID = 'some_remember_me_id';
    private const SOME_NAME = 'some name';
    private const SOME_STRING_VALUE = 'some string';

    /**
     * @var TokenRequestBuilder
     */
    private $requestBuilder;

    /**
     * @var SandboxAnchor
     */
    private $mockAnchor;

    public function setup(): void
    {
        $this->requestBuilder = new TokenRequestBuilder();

        $this->mockAnchor = $this->createMock(SandboxAnchor::class);
        $this->mockAnchor
            ->method('jsonSerialize')
            ->willReturn(['some' => 'anchor']);
    }

    /**
     * @covers ::build
     */
    public function testBuild()
    {
        $tokenRequest = $this->requestBuilder->build();

        $this->assertInstanceOf(TokenRequest::class, $tokenRequest);
    }

    /**
     * @covers ::setRememberMeId
     */
    public function testSetRememberMeId()
    {
        $this->requestBuilder->setRememberMeId(self::SOME_REMEMBER_ME_ID);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'remember_me_id' => self::SOME_REMEMBER_ME_ID,
                'profile_attributes' => []
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setFullName
     * @covers ::setFamilyName
     * @covers ::setGivenNames
     * @covers ::setGender
     * @covers ::setNationality
     * @covers ::setPhoneNumber
     * @covers ::setBase64Selfie
     * @covers ::setEmailAddress
     * @covers ::setPostalAddress
     * @covers ::setStructuredPostalAddress
     * @covers ::createAttribute
     * @covers ::addAttribute
     * @covers ::getAnchors
     *
     * @dataProvider stringAttributeSettersDataProvider
     */
    public function testStringAttributeSetters($setterMethod, $name)
    {
        $this->requestBuilder->{$setterMethod}(self::SOME_STRING_VALUE);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => $name,
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @group legacy
     *
     * @covers ::setFullName
     * @covers ::setFamilyName
     * @covers ::setGivenNames
     * @covers ::setGender
     * @covers ::setNationality
     * @covers ::setPhoneNumber
     * @covers ::setBase64Selfie
     * @covers ::setEmailAddress
     * @covers ::setPostalAddress
     * @covers ::setStructuredPostalAddress
     * @covers ::createAttribute
     * @covers ::addAttribute
     * @covers ::getAnchors
     *
     * @dataProvider stringAttributeSettersDataProvider
     */
    public function testStringAttributeSettersWithOptional($setterMethod, $name)
    {
        $this->expectOptionalDeprecation($setterMethod);

        $this->requestBuilder->{$setterMethod}(self::SOME_STRING_VALUE, true);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => $name,
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setFullName
     * @covers ::setFamilyName
     * @covers ::setGivenNames
     * @covers ::setGender
     * @covers ::setNationality
     * @covers ::setPhoneNumber
     * @covers ::setBase64Selfie
     * @covers ::setEmailAddress
     * @covers ::setPostalAddress
     * @covers ::setStructuredPostalAddress
     * @covers ::createAttribute
     * @covers ::addAttribute
     * @covers ::getAnchors
     *
     * @dataProvider stringAttributeSettersDataProvider
     */
    public function testStringAttributeSettersWithAnchor($setterMethod, $name)
    {
        $this->requestBuilder->{$setterMethod}(self::SOME_STRING_VALUE, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => $name,
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @group legacy
     *
     * @covers ::setFullName
     * @covers ::setFamilyName
     * @covers ::setGivenNames
     * @covers ::setGender
     * @covers ::setNationality
     * @covers ::setPhoneNumber
     * @covers ::setBase64Selfie
     * @covers ::setEmailAddress
     * @covers ::setPostalAddress
     * @covers ::setStructuredPostalAddress
     * @covers ::createAttribute
     * @covers ::addAttribute
     * @covers ::getAnchors
     *
     * @dataProvider stringAttributeSettersDataProvider
     */
    public function testStringAttributeSettersWithOptionalAndAnchor($setterMethod, $name)
    {
        $this->expectOptionalDeprecation($setterMethod);

        $this->requestBuilder->{$setterMethod}(self::SOME_STRING_VALUE, true, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => $name,
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * Provides test data for attribute setters.
     *
     * @return array
     */
    public function stringAttributeSettersDataProvider()
    {
        return [
            ['setFullName', 'full_name'],
            ['setFamilyName', 'family_name'],
            ['setGivenNames', 'given_names'],
            ['setGender', 'gender'],
            ['setNationality', 'nationality'],
            ['setPhoneNumber', 'phone_number'],
            ['setBase64Selfie', 'selfie'],
            ['setEmailAddress', 'email_address'],
            ['setPostalAddress', 'postal_address'],
            ['setStructuredPostalAddress', 'structured_postal_address'],
        ];
    }

    /**
     * @covers ::setDateOfBirth
     */
    public function testSetDateOfBirth()
    {
        $someDOB = new \DateTime();
        $this->requestBuilder->setDateOfBirth($someDOB);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'date_of_birth',
                        'value' => $someDOB->format('Y-m-d'),
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setSelfie
     */
    public function testSetSelfie()
    {
        $this->requestBuilder->setSelfie(self::SOME_STRING_VALUE);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'selfie',
                        'value' => base64_encode(self::SOME_STRING_VALUE),
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setSelfie
     */
    public function testSetSelfieWithAnchor()
    {
        $this->requestBuilder->setSelfie(self::SOME_STRING_VALUE, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'selfie',
                        'value' => base64_encode(self::SOME_STRING_VALUE),
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @group legacy
     *
     * @covers ::setSelfie
     */
    public function testSetSelfieWithOptionalAndAnchor()
    {
        $this->expectOptionalDeprecation('setSelfie');

        $this->requestBuilder->setSelfie(self::SOME_STRING_VALUE, true, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'selfie',
                        'value' => base64_encode(self::SOME_STRING_VALUE),
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setDocumentDetails
     */
    public function testSetDocumentDetails()
    {
        $someDocumentDetails  = $this->createMock(SandboxDocumentDetails::class);
        $someDocumentDetails->method('getValue')->willReturn(self::SOME_STRING_VALUE);

        $this->requestBuilder->setDocumentDetails($someDocumentDetails);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_details',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setDocumentDetails
     */
    public function testSetDocumentDetailsWithAnchor()
    {
        $someDocumentDetails  = $this->createMock(SandboxDocumentDetails::class);
        $someDocumentDetails->method('getValue')->willReturn(self::SOME_STRING_VALUE);

        $this->requestBuilder->setDocumentDetails($someDocumentDetails, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_details',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @group legacy
     *
     * @covers ::setDocumentDetails
     */
    public function testSetDocumentDetailsWithOptionalAndAnchor()
    {
        $this->expectOptionalDeprecation('setDocumentDetails');

        $someDocumentDetails  = $this->createMock(SandboxDocumentDetails::class);
        $someDocumentDetails->method('getValue')->willReturn(self::SOME_STRING_VALUE);

        $this->requestBuilder->setDocumentDetails($someDocumentDetails, true, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_details',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setDocumentDetailsWithString
     */
    public function testSetDocumentDetailsWithStringAndAnchors()
    {
        $this->requestBuilder->setDocumentDetailsWithString(self::SOME_STRING_VALUE, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_details',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @group legacy
     *
     * @covers ::setDocumentDetailsWithString
     */
    public function testSetDocumentDetailsWithStringAndOptionalAndAnchors()
    {
        $this->expectOptionalDeprecation('setDocumentDetailsWithString');

        $this->requestBuilder->setDocumentDetailsWithString(self::SOME_STRING_VALUE, true, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_details',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setAgeVerification
     */
    public function testSetAgeVerification()
    {
        $someAgeVerification  = $this->createMock(SandboxAgeVerification::class);
        $someAgeVerification->method('jsonSerialize')->willReturn([
            'name' => self::SOME_NAME,
            'value' => self::SOME_STRING_VALUE,
        ]);

        $this->requestBuilder->setAgeVerification($someAgeVerification);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [$someAgeVerification]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setExtraData
     */
    public function testSetExtraData()
    {
        $someExtraData  = $this->createMock(SandboxExtraData::class);
        $someExtraData->method('jsonSerialize')->willReturn((object) ['some' => 'extra-data']);

        $tokenRequest = $this->requestBuilder->setExtraData($someExtraData)->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [],
                'extra_data' => $someExtraData,
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setDocumentImages
     */
    public function testSetDocumentImages()
    {
        $someDocumentImages  = $this->createMock(SandboxDocumentImages::class);
        $someDocumentImages->method('getValue')->willReturn(self::SOME_STRING_VALUE);

        $this->requestBuilder->setDocumentImages($someDocumentImages);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_images',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * @covers ::setDocumentImages
     */
    public function testSetDocumentImagesWithAnchor()
    {
        $someDocumentImages  = $this->createMock(SandboxDocumentImages::class);
        $someDocumentImages->method('getValue')->willReturn(self::SOME_STRING_VALUE);

        $this->requestBuilder->setDocumentImages($someDocumentImages, [$this->mockAnchor]);
        $tokenRequest = $this->requestBuilder->build();

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'profile_attributes' => [
                    [
                        'name' => 'document_images',
                        'value' => self::SOME_STRING_VALUE,
                        'derivation' => '',
                        'anchors' => [$this->mockAnchor],
                    ]
                ]
            ]),
            json_encode($tokenRequest)
        );
    }

    /**
     * Expect deprecation error for optional parameter.
     *
     * @param string $method
     */
    private function expectOptionalDeprecation($method): void
    {
        $this->expectDeprecation(sprintf(
            'Boolean argument 2 passed to %s::%s is deprecated in 1.1.0 and will be removed in 2.0.0',
            TokenRequestBuilder::class,
            $method
        ));
    }
}
