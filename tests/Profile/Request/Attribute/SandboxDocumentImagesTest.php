<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Test\Profile\Request\Attribute;

use Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder;
use Yoti\Sandbox\Test\TestCase;

/**
 * @coversDefaultClass \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImages
 */
class SandboxDocumentImagesTest extends TestCase
{
    private const SOME_CONTENT = 'some-content';

    /**
     * @covers ::__construct
     * @covers ::getValue
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::withJpegContent
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::withImage
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::build
     */
    public function testGetValueWithJpeg()
    {
        $sandboxDocumentImages = (new SandboxDocumentImagesBuilder())
            ->withJpegContent(self::SOME_CONTENT)
            ->build();

        $this->assertEquals(
            self::dataUrl(self::SOME_CONTENT, 'image/jpeg'),
            $sandboxDocumentImages->getValue()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::getValue
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::withPngContent
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::withImage
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::build
     */
    public function testGetValueWithPng()
    {
        $sandboxDocumentImages = (new SandboxDocumentImagesBuilder())
            ->withPngContent(self::SOME_CONTENT)
            ->build();

        $this->assertEquals(
            self::dataUrl(self::SOME_CONTENT, 'image/png'),
            $sandboxDocumentImages->getValue()
        );
    }

    /**
     * @covers ::__construct
     * @covers ::getValue
     * @covers \Yoti\Sandbox\Profile\Request\Attribute\SandboxDocumentImagesBuilder::withImage
     */
    public function testGetValueMultipleImages()
    {
        $sandboxDocumentImages = (new SandboxDocumentImagesBuilder())
            ->withJpegContent(self::SOME_CONTENT)
            ->withPngContent(self::SOME_CONTENT)
            ->withPngContent(self::SOME_CONTENT)
            ->build();

        $this->assertEquals(
            sprintf(
                '%s&%s&%s',
                self::dataUrl(self::SOME_CONTENT, 'image/jpeg'),
                self::dataUrl(self::SOME_CONTENT, 'image/png'),
                self::dataUrl(self::SOME_CONTENT, 'image/png')
            ),
            $sandboxDocumentImages->getValue()
        );
    }

    /**
     * @param string $content
     * @param string $contentType
     *
     * @return string
     */
    private static function dataUrl(string $content, string $contentType): string
    {
        return sprintf('data:%s;base64,%s', $contentType, base64_encode($content));
    }
}
