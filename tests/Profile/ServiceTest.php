<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Yoti\Http\Payload;
use Yoti\Sandbox\Profile\Request\TokenRequest;
use Yoti\Sandbox\Profile\Service;
use Yoti\Sandbox\Test\TestCase;
use Yoti\Sandbox\Test\TestData;
use Yoti\Util\Config;
use Yoti\Util\PemFile;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Service
 */
class ServiceTest extends TestCase
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

        $service = new Service(
            TestData::SDK_ID,
            PemFile::fromFilePath(TestData::PEM_FILE),
            new Config([
                Config::HTTP_CLIENT => $mockHttpClient,
            ])
        );

        $mockTokenRequest = $this->createMock(TokenRequest::class);
        $mockTokenRequest
            ->method('getPayload')
            ->willReturn($this->createMock(Payload::class));

        $token = $service->setupSharingProfile($mockTokenRequest);

        $this->assertEquals(self::SOME_TOKEN, $token);
    }
}
