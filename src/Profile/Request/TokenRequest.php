<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request;

use Yoti\Http\Payload;
use Yoti\Sandbox\Profile\Request\Attribute\SandboxAttribute;
use Yoti\Sandbox\Profile\Request\ExtraData\SandboxExtraData;
use Yoti\Util\Json;
use Yoti\Util\Validation;

class TokenRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $rememberMeId;

    /**
     * @var SandboxAttribute[]
     */
    private $sandboxAttributes;

    /**
     * @var SandboxExtraData|null
     */
    private $extraData;

    /**
     * @param string|null $rememberMeId
     * @param SandboxAttribute[] $sandboxAttributes
     */
    public function __construct(?string $rememberMeId, array $sandboxAttributes, ?SandboxExtraData $extraData = null)
    {
        $this->rememberMeId = $rememberMeId;

        Validation::isArrayOfType($sandboxAttributes, [ SandboxAttribute::class ], 'sandboxAttributes');
        $this->sandboxAttributes = $sandboxAttributes;

        $this->extraData = $extraData;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return Json::withoutNullValues([
            'remember_me_id' => $this->rememberMeId,
            'profile_attributes' => $this->sandboxAttributes,
            'extra_data' => $this->extraData,
        ]);
    }

    /**
     * @return Payload
     */
    public function getPayload(): Payload
    {
        return Payload::fromJsonData($this);
    }
}
