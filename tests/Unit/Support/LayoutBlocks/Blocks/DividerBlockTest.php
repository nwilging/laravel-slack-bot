<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\DividerBlock;
use Tests\TestCase;

class DividerBlockTest extends TestCase
{
    public function testBlock()
    {
        $block = new DividerBlock('block-id');
        $this->assertSame(Block::TYPE_DIVIDER, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_DIVIDER,
            'block_id' => 'block-id',
        ], $block->toArray());
    }

    public function testBlockNoBlockId()
    {
        $block = new DividerBlock();
        $this->assertSame(Block::TYPE_DIVIDER, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_DIVIDER,
        ], $block->toArray());
    }
}
