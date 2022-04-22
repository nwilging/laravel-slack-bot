<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;

class DividerBlock extends Block
{
    public function getType(): string
    {
        return static::TYPE_DIVIDER;
    }
}
