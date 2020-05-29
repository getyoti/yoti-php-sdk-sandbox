<?php

namespace Yoti\Sandbox\Test\DocScan\Exception;

use Psr\Http\Message\ResponseInterface;
use Yoti\Sandbox\DocScan\Exception\SandboxDocScanException;
use Yoti\Sandbox\Test\TestCase;

class SandboxDocScanExceptionTest extends TestCase
{
    private const SOME_ERROR_MESSAGE = 'Some Error Message';

    /**
     * @test
     */
    public function shouldStoreResponse()
    {
        $responseMock = $this->createMock(ResponseInterface::class);

        $docScanException = new SandboxDocScanException(self::SOME_ERROR_MESSAGE, $responseMock);
        $this->assertEquals(self::SOME_ERROR_MESSAGE, $docScanException->getMessage());
        $this->assertEquals($responseMock, $docScanException->getResponse());
    }
}
