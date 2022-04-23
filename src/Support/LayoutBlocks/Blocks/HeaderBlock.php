<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Header Block
 * @see https://api.slack.com/reference/block-kit/blocks#header
 */
class HeaderBlock extends Block
{
    use MergesArrays;

    protected TextObject $textObject;

    public function __construct(TextObject $textObject, ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->textObject = $textObject;
    }

    public function getType(): string
    {
        return static::TYPE_HEADER;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'text' => $this->textObject->toArray(),
        ]);
    }
}
