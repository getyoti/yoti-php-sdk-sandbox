<?php

namespace Yoti\Sandbox\Test\DocScan\Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Yoti\Sandbox\DocScan\Exception\SandboxDocScanException;
use Yoti\Sandbox\Test\TestCase;

class SandboxDocScanExceptionTest extends TestCase
{
    private const SOME_MESSAGE = 'Some message';
    private const SOME_RESPONSE_CODE = 'SOME_ERROR_CODE';
    private const SOME_RESPONSE_MESSAGE = 'Some response message';
    private const SOME_PROPERTY = 'some.property';
    private const SOME_PROPERTY_MESSAGE = 'Some property message';
    private const SOME_OTHER_PROPERTY = 'some.other.property';
    private const SOME_OTHER_PROPERTY_MESSAGE = 'Some other property message';

    /**
     * @test
     */
    public function responseShouldBeOptional()
    {
        $docScanException = new SandboxDocScanException(self::SOME_MESSAGE);
        $this->assertEquals(self::SOME_MESSAGE, $docScanException->getMessage());
    }

    /**
     * @test
     */
    public function shouldStoreResponse()
    {
        $responseMock = $this->createMock(ResponseInterface::class);

        $docScanException = new SandboxDocScanException(self::SOME_MESSAGE, $responseMock);
        $this->assertEquals(self::SOME_MESSAGE, $docScanException->getMessage());
        $this->assertSame($responseMock, $docScanException->getResponse());
    }

    /**
     * @test
     */
    public function shouldExcludeNonJsonResponsesFromMessage()
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('hasHeader')->willReturn(true);
        $responseMock->method('getHeader')->willReturn(['text/html']);

        $docScanException = new SandboxDocScanException(self::SOME_MESSAGE, $responseMock);

        $this->assertEquals(self::SOME_MESSAGE, $docScanException->getMessage());
        $this->assertEquals($responseMock, $docScanException->getResponse());
    }

    /**
     * @test
     *
     * @dataProvider jsonResponseMessageDataProvider
     */
    public function shouldIncludeFormattedResponseInMessage($message, $jsonData, $expectedMessage)
    {
        $body = $this->createMock(StreamInterface::class);
        $body->method('__toString')->willReturn(json_encode($jsonData));

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('hasHeader')->willReturn(true);
        $responseMock->method('getHeader')->willReturn(['application/json']);
        $responseMock->method('getBody')->willReturn($body);

        $docScanException = new SandboxDocScanException($message, $responseMock);

        $this->assertEquals($expectedMessage, $docScanException->getMessage());
        $this->assertEquals($responseMock, $docScanException->getResponse());
    }

    /**
     * Provides JSON response data and their expected exception message.
     *
     * @return array
     */
    public function jsonResponseMessageDataProvider(): array
    {
        return [
            /**
             * Message and code.
             */
            [
                self::SOME_MESSAGE,
                [
                    'message' => self::SOME_RESPONSE_MESSAGE,
                    'code' => self::SOME_RESPONSE_CODE
                ],
                sprintf(
                    '%s - %s - %s',
                    self::SOME_MESSAGE,
                    self::SOME_RESPONSE_CODE,
                    self::SOME_RESPONSE_MESSAGE
                ),
            ],
            /**
             * Message, code and errors with some unknown items
             */
            [
                self::SOME_MESSAGE,
                [
                    'message' => self::SOME_RESPONSE_MESSAGE,
                    'code' => self::SOME_RESPONSE_CODE,
                    'errors' => [
                        [
                            'some_unknown_item' => 'some unknown item',
                            'message' => self::SOME_PROPERTY_MESSAGE,
                        ],
                        [
                            'property' => self::SOME_PROPERTY,
                            'some_unknown_item' => 'some unknown item',
                        ],
                        [
                            'property' => self::SOME_OTHER_PROPERTY,
                            'message' => self::SOME_OTHER_PROPERTY_MESSAGE,
                        ],
                    ],
                ],
                sprintf(
                    '%s - %s - %s: %s "%s"',
                    self::SOME_MESSAGE,
                    self::SOME_RESPONSE_CODE,
                    self::SOME_RESPONSE_MESSAGE,
                    self::SOME_OTHER_PROPERTY,
                    self::SOME_OTHER_PROPERTY_MESSAGE
                ),
            ],
            /**
             * Message, code and errors with unknown items
             */
            [
                self::SOME_MESSAGE,
                [
                    'message' => self::SOME_RESPONSE_MESSAGE,
                    'code' => self::SOME_RESPONSE_CODE,
                    'errors' => [
                        [
                            'some_unknown_item' => 'some unknown item',
                            'message' => self::SOME_PROPERTY_MESSAGE,
                        ],
                        [
                            'property' => self::SOME_PROPERTY,
                            'some_unknown_item' => 'some unknown item',
                        ],
                    ],
                ],
                sprintf(
                    '%s - %s - %s',
                    self::SOME_MESSAGE,
                    self::SOME_RESPONSE_CODE,
                    self::SOME_RESPONSE_MESSAGE
                ),
            ],
            /**
             * Message, code and errors.
             */
            [
                self::SOME_MESSAGE,
                [
                    'message' => self::SOME_RESPONSE_MESSAGE,
                    'code' => self::SOME_RESPONSE_CODE,
                    'errors' => [
                        [
                            'property' => self::SOME_PROPERTY,
                            'message' => self::SOME_PROPERTY_MESSAGE,
                        ],
                        [
                            'property' => self::SOME_OTHER_PROPERTY,
                            'message' => self::SOME_OTHER_PROPERTY_MESSAGE,
                        ],
                    ],
                ],
                sprintf(
                    '%s - %s - %s: %s "%s", %s "%s"',
                    self::SOME_MESSAGE,
                    self::SOME_RESPONSE_CODE,
                    self::SOME_RESPONSE_MESSAGE,
                    self::SOME_PROPERTY,
                    self::SOME_PROPERTY_MESSAGE,
                    self::SOME_OTHER_PROPERTY,
                    self::SOME_OTHER_PROPERTY_MESSAGE
                ),
            ],
            /**
             * Message without code.
             */
            [
                self::SOME_MESSAGE,
                [
                    'message' => self::SOME_RESPONSE_MESSAGE,
                ],
                self::SOME_MESSAGE,
            ],
            /**
             * Code without message.
             */
            [
                self::SOME_MESSAGE,
                [
                    'code' => self::SOME_RESPONSE_CODE,
                ],
                self::SOME_MESSAGE,
            ],
        ];
    }
}
