<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\ImageElement;
use Nwilging\LaravelSlackBotTests\TestCase;

class ImageElementTest extends TestCase
{
    public function testElement()
    {
        $imageUrl = 'https://example.com';
        $altText = 'test alt text';

        $element = new ImageElement($imageUrl, $altText);

        $this->assertEquals([
            'type' => Element::TYPE_IMAGE,
            'image_url' => $imageUrl,
            'alt_text' => $altText,
        ], $element->toArray());

        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_CONTEXT,
        ], $element->compatibleWith());
    }
}
