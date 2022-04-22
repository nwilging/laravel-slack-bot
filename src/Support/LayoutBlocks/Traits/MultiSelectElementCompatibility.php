<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;

trait MultiSelectElementCompatibility
{
    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
        ];
    }
}
