<?php

declare(strict_types=1);

namespace Yoti\Sandbox;

use Yoti\Sandbox\Profile\Request\TokenRequest;
use Yoti\Sandbox\Profile\Service as ProfileService;
use Yoti\Util\Config;
use Yoti\Util\PemFile;

class SandboxClient
{
    /**
     * @var \Yoti\Sandbox\Profile\Service
     */
    private $profileService;

    /**
     * SandboxClient constructor.
     *
     * @param string $sdkId
     *   The SDK identifier generated by Yoti Hub when you create your app.
     * @param string $pem
     *   PEM file path or string
     * @param array<string, mixed> $options (optional)
     *   SDK configuration options - {@see \Yoti\Util\Config} for available options.
     */
    public function __construct(
        string $sdkId,
        string $pem,
        array $options = []
    ) {
        $pemFile = Pemfile::resolveFromString($pem);
        $config = new Config($options);

        $this->profileService = new ProfileService($sdkId, $pemFile, $config);
    }

    /**
     * @param \Yoti\Sandbox\Profile\Request\TokenRequest $tokenRequest
     *
     * @return string
     */
    public function setupSharingProfile(TokenRequest $tokenRequest): string
    {
        return $this->profileService->setupSharingProfile($tokenRequest);
    }
}
