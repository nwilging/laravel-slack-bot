<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Image Element
 * @see https://api.slack.com/reference/block-kit/block-elements#image
 */
class ImageElement extends Element
{
    use MergesArrays;

    protected string $imageUrl;

    protected string $altText;

    public function __construct(string $imageUrl, string $altText)
    {
        $this->imageUrl = $imageUrl;
        $this->altText = $altText;
    }

    public function getType(): string
    {
        return Element::TYPE_IMAGE;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
            Block::TYPE_CONTEXT,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'image_url' => $this->imageUrl,
            'alt_text' => $this->altText,
        ]);
    }
}
