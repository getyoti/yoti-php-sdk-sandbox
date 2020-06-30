<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request;

use Yoti\Profile\UserProfile;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAgeVerification;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentDetails;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImages;
use Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraData;

class TokenRequestBuilder
{
    /**
     * @var string
     */
    private $rememberMeId;

    /**
     * @var SandboxAttribute[]
     */
    private $sandboxAttributes = [];

    /**
     * @var SandboxExtraData|null
     */
    private $extraData;

    /**
     * @param string $value
     */
    public function setRememberMeId($value): self
    {
        $this->rememberMeId = $value;
        return $this;
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setFullName(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_FULL_NAME,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setFamilyName(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_FAMILY_NAME,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setGivenNames(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_GIVEN_NAMES,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param \DateTime $dateTime
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setDateOfBirth(\DateTime $dateTime, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_DATE_OF_BIRTH,
            $dateTime->format('Y-m-d'),
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setGender(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_GENDER,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setNationality(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_NATIONALITY,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setPhoneNumber(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_PHONE_NUMBER,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setSelfie(string $value, $anchors = []): self
    {
        return $this->setBase64Selfie(
            base64_encode($value),
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setBase64Selfie(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_SELFIE,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setEmailAddress(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_EMAIL_ADDRESS,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setPostalAddress(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_POSTAL_ADDRESS,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setStructuredPostalAddress(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_STRUCTURED_POSTAL_ADDRESS,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentDetails $documentDetails
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setDocumentDetails(
        SandboxDocumentDetails $documentDetails,
        $anchors = []
    ): self {
        return $this->createAttribute(
            UserProfile::ATTR_DOCUMENT_DETAILS,
            $documentDetails->getValue(),
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setDocumentDetailsWithString(string $value, $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_DOCUMENT_DETAILS,
            $value,
            $this->getAnchors($anchors, func_get_args(), __METHOD__)
        );
    }

    /**
     * @param SandboxAgeVerification $ageVerification
     *
     * @return $this
     */
    public function setAgeVerification(SandboxAgeVerification $ageVerification): self
    {
        return $this->addAttribute($ageVerification);
    }

    /**
     * @param SandboxDocumentImages $documentImages
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    public function setDocumentImages(SandboxDocumentImages $documentImages, array $anchors = []): self
    {
        return $this->createAttribute(
            UserProfile::ATTR_DOCUMENT_IMAGES,
            $documentImages->getValue(),
            $anchors
        );
    }

    /**
     * @param SandboxAttribute $attribute
     *
     * @return $this
     */
    public function addAttribute(SandboxAttribute $attribute): self
    {
        $this->sandboxAttributes[] = $attribute;
        return $this;
    }

    /**
     * @param SandboxExtraData $extraData
     *
     * @return self
     */
    public function setExtraData(SandboxExtraData $extraData): self
    {
        $this->extraData = $extraData;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[] $anchors
     *
     * @return $this
     */
    private function createAttribute(
        string $name,
        string $value,
        array $anchors
    ): self {
        return $this->addAttribute(new SandboxAttribute($name, $value, '', $anchors));
    }

    /**
     * Get the anchors from the provided arguments.
     *
     * This provides backward compatibility for implementations providing
     * the optional parameter, which has now been removed.
     *
     * @param mixed $anchors
     *   The parameter expected to be an array of anchors.
     * @param array<mixed> $args
     *   The builder method args.
     * @param string $method
     *   The builder method being called.
     *
     * @return \Yoti\Sandbox\Profile\Request\Attribute\SandboxAnchor[]
     */
    private function getAnchors($anchors, array $args, string $method): array
    {
        if (is_array($anchors)) {
            return $anchors;
        }

        if (is_bool($args[1])) {
            @trigger_error(
                "Boolean argument 2 passed to {$method} is deprecated in 1.1.0 and will be removed in 2.0.0",
                E_USER_DEPRECATED
            );
        }

        return $args[2] ?? [];
    }

    /**
     * @return \Yoti\Sandbox\Profile\Request\TokenRequest
     */
    public function build(): TokenRequest
    {
        return new TokenRequest($this->rememberMeId, $this->sandboxAttributes, $this->extraData);
    }
}
