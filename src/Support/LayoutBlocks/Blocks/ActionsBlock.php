<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasElements;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class ActionsBlock extends Block
{
    use HasElements, MergesArrays;

    public function __construct(array $elements, ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->elements = $elements;
    }

    public function getType(): string
    {
        return static::TYPE_ACTIONS;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'elements' => $this->elementsArray(),
            'block_id' => $this->blockId,
        ]);
    }
}
