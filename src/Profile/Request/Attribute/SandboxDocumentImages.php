<?php

declare(strict_types=1);

namespace Yoti\Sandbox\Profile\Request\Attribute;

use Yoti\Media\Image;
use Yoti\Util\Validation;

class SandboxDocumentImages
{
    /**
     * @var Image[]
     */
    private $images;

    /**
     * @param Image[] $images
     */
    public function __construct(array $images)
    {
        Validation::isArrayOfType($images, [Image::class], 'images');
        $this->images = $images;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return implode('&', array_map(
            function (Image $image): string {
                return $image->getBase64Content();
            },
            $this->images
        ));
    }
}
