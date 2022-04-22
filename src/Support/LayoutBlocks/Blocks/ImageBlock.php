<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class ImageBlock extends Block
{
    use MergesArrays;

    protected string $imageUrl;

    protected string $altText;

    protected ?TextObject $title = null;

    public function __construct(string $imageUrl, string $altText, ?string $blockId = null)
    {
        parent::__construct($blockId);

        $this->imageUrl = $imageUrl;
        $this->altText = $altText;
    }

    public function withTitle(TextObject $textObject): self
    {
        $this->title = $textObject;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_IMAGE;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'image_url' => $this->imageUrl,
            'alt_text' => $this->altText,
            'title' => ($this->title) ? $this->title->toArray() : null,
        ]);
    }
}
