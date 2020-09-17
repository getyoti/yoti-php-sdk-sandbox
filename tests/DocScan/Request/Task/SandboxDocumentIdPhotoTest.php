<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\DocScan\Request\Task;

use Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentIdPhoto;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\DocScan\Request\Task\SandboxDocumentIdPhoto
 */
class SandboxDocumentIdPhotoTest extends TestCase
{
    private const SOME_IMAGE_CONTENT_TYPE = 'image/jpeg';
    private const SOME_IMAGE_CONTENT = 'someImageContent';

    /**
     * @test
     * @covers ::__construct
     * @covers ::jsonSerialize
     */
    public function shouldSerializeToJson(): void
    {
        $documentIdPhoto = new SandboxDocumentIdPhoto(
            self::SOME_IMAGE_CONTENT_TYPE,
            self::SOME_IMAGE_CONTENT
        );

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'content_type' => self::SOME_IMAGE_CONTENT_TYPE,
                'data' => base64_encode(self::SOME_IMAGE_CONTENT),
            ]),
            json_encode($documentIdPhoto)
        );
    }
}
