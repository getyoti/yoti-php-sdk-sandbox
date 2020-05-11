<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Yoti\Sandbox\DocScan\Exception\SandboxDocScanException;
use Yoti\Sandbox\DocScan\SandboxClient;
use Yoti\Sandbox\DocScan\SandboxResponseConfig;
use Yoti\Sandbox\Test\TestCase;
use Yoti\Sandbox\Test\TestData;
use Yoti\Util\Config;

class SandboxClientTest extends TestCase
{
    private const DOC_SCAN_SANDBOX_BASE_URL = 'https://api.yoti.com/sandbox/idverify/v1';
    private const SOME_SESSION_ID = 'someSessionId';
    private const SOME_SDK_ID = 'someSdkId';

    /**
     * @test
     * @throws \Yoti\Exception\PemFileException
     */
    public function shouldConfigureResponseForSessionCorrectly()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $responseConfigMock = $this->createMock(SandboxResponseConfig::class);
        $responseConfigMock->method('jsonSerialize')->willReturn((object) ['key' => 'value']);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->exactly(1))
            ->method('sendRequest')
            ->with(
                $this->callback(
                    function (RequestInterface $requestMessage) {
                        $expectedPathPattern = sprintf(
                            '~^%s/sessions/%s/response-config\?sdkId=%s&nonce=.*?&timestamp=.*?~',
                            self::DOC_SCAN_SANDBOX_BASE_URL,
                            self::SOME_SESSION_ID,
                            'someSdkId'
                        );

                        $this->assertEquals('PUT', $requestMessage->getMethod());
                        $this->assertRegExp($expectedPathPattern, (string)$requestMessage->getUri());
                        return true;
                    }
                )
            )
            ->willReturn($response);

        $docScanSandboxClient = new SandboxClient(
            self::SOME_SDK_ID,
            TestData::PEM_FILE,
            new Config([
                Config::HTTP_CLIENT => $httpClient
            ])
        );

        $docScanSandboxClient->configureSessionResponse(self::SOME_SESSION_ID, $responseConfigMock);
    }

    /**
     * @test
     * @throws \Yoti\Exception\PemFileException
     */
    public function shouldCreateResponseForApplicationCorrectly()
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(200);

        $responseConfigMock = $this->createMock(SandboxResponseConfig::class);
        $responseConfigMock->method('jsonSerialize')->willReturn((object) ['key' => 'value']);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->exactly(1))
            ->method('sendRequest')
            ->with(
                $this->callback(
                    function (RequestInterface $requestMessage) {
                        $expectedPathPattern = sprintf(
                            '~^%s/apps/%s/response-config\?sdkId=%s&nonce=.*?&timestamp=.*?~',
                            self::DOC_SCAN_SANDBOX_BASE_URL,
                            self::SOME_SDK_ID,
                            self::SOME_SDK_ID
                        );

                        $this->assertEquals('PUT', $requestMessage->getMethod());
                        $this->assertRegExp($expectedPathPattern, (string)$requestMessage->getUri());
                        return true;
                    }
                )
            )
            ->willReturn($response);

        $docScanSandboxClient = new SandboxClient(
            self::SOME_SDK_ID,
            TestData::PEM_FILE,
            new Config([
                Config::HTTP_CLIENT => $httpClient
            ])
        );

        $docScanSandboxClient->configureApplicationResponse($responseConfigMock);
    }

    /**
     * @test
     * @throws \Yoti\Exception\PemFileException
     */
    public function shouldThrowSandboxDocScanExceptionOnBadStatusCode()
    {
        $this->expectException(SandboxDocScanException::class);
        $this->expectExceptionMessage('Failed on status code: 400');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getStatusCode')->willReturn(400);

        $responseConfigMock = $this->createMock(SandboxResponseConfig::class);
        $responseConfigMock->method('jsonSerialize')->willReturn((object) ['key' => 'value']);

        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects($this->exactly(1))
            ->method('sendRequest')
            ->willReturn($response);

        $docScanSandboxClient = new SandboxClient(
            self::SOME_SDK_ID,
            TestData::PEM_FILE,
            new Config([
                Config::HTTP_CLIENT => $httpClient
            ])
        );

        $docScanSandboxClient->configureApplicationResponse($responseConfigMock);
    }
}
