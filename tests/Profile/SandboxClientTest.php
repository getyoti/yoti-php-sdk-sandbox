<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Yoti\Http\Payload;
use Yoti\Sandbox\Profile\Request\TokenRequest;
use Yoti\Sandbox\Profile\SandboxClient;
use Yoti\Util\Config;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\SandboxClient
 */
class SandboxClientTest extends TestCase
{
    private const SOME_TOKEN = 'some-token';

    /**
     * @covers ::setupSharingProfile
     * @covers ::__construct
     */
    public function testSetupSharingProfile()
    {
        $mockResponse = $this->createMock(ResponseInterface::class);
        $mockResponse
            ->method('getBody')
            ->willReturn(json_encode([
                'token' => self::SOME_TOKEN
            ]));
        $mockResponse
            ->method('getStatusCode')
            ->willReturn(201);

        $mockHttpClient = $this->createMock(ClientInterface::class);
        $mockHttpClient->method('sendRequest')->willReturn($mockResponse);

        $sandboxClient = new SandboxClient(
            TestData::SDK_ID,
            TestData::PEM_FILE,
            [
                Config::HTTP_CLIENT => $mockHttpClient,
            ]
        );

        $mockTokenRequest = $this->createMock(TokenRequest::class);
        $mockTokenRequest
            ->method('getPayload')
            ->willReturn($this->createMock(Payload::class));

        $token = $sandboxClient->setupSharingProfile($mockTokenRequest);

        $this->assertEquals(self::SOME_TOKEN, $token);
    }
}
