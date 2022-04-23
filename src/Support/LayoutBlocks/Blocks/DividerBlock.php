<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;

/**
 * Divider Block
 * https://api.slack.com/reference/block-kit/blocks#divider
 */
class DividerBlock extends Block
{
    public function getType(): string
    {
        return static::TYPE_DIVIDER;
    }
}
