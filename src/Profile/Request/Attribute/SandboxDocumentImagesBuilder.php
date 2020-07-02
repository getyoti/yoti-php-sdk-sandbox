<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\Attribute;

use Yoti\Media\Image;
use Yoti\Media\Image\Jpeg;
use Yoti\Media\Image\Png;

class SandboxDocumentImagesBuilder
{
    /**
     * @var Image[]
     */
    private $images = [];

    /**
     * @param Image $image
     *
     * @return $this
     */
    private function withImage(Image $image): self
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function withJpegContent(string $content): self
    {
        return $this->withImage(new Jpeg($content));
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function withPngContent(string $content): self
    {
        return $this->withImage(new Png($content));
    }

    /**
     * @return SandboxDocumentImages
     */
    public function build(): SandboxDocumentImages
    {
        return new SandboxDocumentImages($this->images);
    }
}
