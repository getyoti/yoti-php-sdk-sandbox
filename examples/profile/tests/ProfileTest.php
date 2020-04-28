<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Examples\Profile\Test;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor;
use Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraDataBuilder;
use Yoti\Sandbox\Profile\Request\ExtraData\ThirdParty\SandboxAttributeIssuanceDetailsBuilder;
use Yoti\Sandbox\Profile\Request\TokenRequestBuilder;
use Yoti\Sandbox\Profile\SandboxClient;
use Yoti\YotiClient;

class ProfileTest extends PHPUnitTestCase
{
    /**
     * @var SandboxClient
     */
    private $sandboxClient;

    /**
     * @var YotiClient
     */
    private $yotiClient;

    public function setup(): void
    {
        $this->sandboxClient = new SandboxClient(
            $_ENV['YOTI_SANDBOX_CLIENT_SDK_ID'],
            $_ENV['YOTI_KEY_FILE_PATH']
        );

        $this->yotiClient = new YotiClient(
            $_ENV['YOTI_SANDBOX_CLIENT_SDK_ID'],
            $_ENV['YOTI_KEY_FILE_PATH'],
            [
                'api.url' => 'https://api.yoti.com/sandbox/v1'
            ]
        );
    }

    /**
     * @test
     */
    public function shouldReturnUserProfile()
    {
        $anchors = [
            new SandboxAnchor('SOURCE', 'PASSPORT', '', new \DateTime()),
            new SandboxAnchor('VERIFIER', 'YOTI_ADMIN', '', new \DateTime()),
        ];

        $ageVerification = SandboxAgeVerification::forAgeOver(
            18,
            new \DateTime('1980-01-01')
        );

        $extraData = (new SandboxExtraDataBuilder())
            ->withDataEntry(
                (new SandboxAttributeIssuanceDetailsBuilder())
                    ->withDefinition('some-definition')
                    ->withExpiryDate(new \DateTime('2020-01-01T00:00:00Z'))
                    ->withIssuanceToken('some-token')
                    ->build()
            )
            ->build();

        $tokenRequest = (new TokenRequestBuilder())
            ->setRememberMeId('Some Remember Me ID')
            ->setGivenNames('Some Given Names', $anchors)
            ->setFamilyName('Some Family Name', $anchors)
            ->setFullName('Some Full Name', $anchors)
            ->setDateOfBirth(new \DateTime('1980-01-01'), $anchors)
            ->setGender('Some Gender', $anchors)
            ->setPhoneNumber('Some Phone Number')
            ->setNationality('Some Nationality', $anchors)
            ->setEmailAddress('some@email.address')
            ->setBase64Selfie(base64_encode('Some Selfie'))
            ->setAgeVerification($ageVerification)
            ->setDocumentDetailsWithString('PASSPORT USA 1234abc', $anchors)
            ->setStructuredPostalAddress(json_encode([
                'building_number' => 1,
                'address_line1' => 'Some Address',
            ]))
            ->setExtraData($extraData)
            ->build();

        $token = $this->sandboxClient->setupSharingProfile($tokenRequest);

        $activityDetails = $this->yotiClient->getActivityDetails($token);
        $profile = $activityDetails->getProfile();

        $this->assertEquals('Some Remember Me ID', base64_decode($activityDetails->getRememberMeId()));
        $this->assertEquals('Some Given Names', $profile->getGivenNames()->getValue());
        $this->assertEquals('Some Family Name', $profile->getFamilyName()->getValue());
        $this->assertEquals('Some Full Name', $profile->getFullName()->getValue());
        $this->assertEquals('1980-01-01', $profile->getDateOfBirth()->getValue()->format('Y-m-d'));
        $this->assertEquals('Some Gender', $profile->getGender()->getValue());
        $this->assertEquals('Some Phone Number', $profile->getPhoneNumber()->getValue());
        $this->assertEquals('Some Nationality', $profile->getNationality()->getValue());
        $this->assertEquals('some@email.address', $profile->getEmailAddress()->getValue());
        $this->assertEquals('Some Selfie', $profile->getSelfie()->getValue()->getContent());
        $this->assertTrue($profile->findAgeOverVerification(18)->getResult());
        $this->assertEquals(
            [
                'building_number' => 1,
                'address_line1' => 'Some Address',
            ],
            $profile->getStructuredPostalAddress()->getValue()
        );

        $documentDetails = $profile->getDocumentDetails()->getValue();
        $this->assertEquals('PASSPORT', $documentDetails->getType());
        $this->assertEquals('USA', $documentDetails->getIssuingCountry());
        $this->assertEquals('1234abc', $documentDetails->getDocumentNumber());

        $this->assertEquals('PASSPORT', $profile->getGivenNames()->getSources()[0]->getValue());
        $this->assertEquals('YOTI_ADMIN', $profile->getGivenNames()->getVerifiers()[0]->getValue());

        $attributeIssuanceDetails = $activityDetails->getExtraData()->getAttributeIssuanceDetails();
        $this->assertEquals(base64_encode('some-token'), $attributeIssuanceDetails->getToken());
        $this->assertEquals(
            '2020-01-01T00:00:00+00:00',
            $attributeIssuanceDetails->getExpiryDate()->format(DATE_RFC3339)
        );
        $this->assertEquals(
            'some-definition',
            $attributeIssuanceDetails->getIssuingAttributes()[0]->getName()
        );
    }
}
