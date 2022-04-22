<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\ActionsBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use PHPUnit\Framework\TestCase;

class ActionsBlockTest extends TestCase
{
    public function testBlock()
    {
        $expectedElementArray = ['key' => 'val'];
        $element = \Mockery::mock(Element::class);
        $element->shouldReceive('toArray')->andReturn($expectedElementArray);

        $block = new ActionsBlock([$element], 'block-id');
        $this->assertSame(Block::TYPE_ACTIONS, $block->getType());

        $this->assertEquals([
            'type' => Block::TYPE_ACTIONS,
            'block_id' => 'block-id',
            'elements' => [$expectedElementArray]
        ], $block->toArray());
    }

    public function testBlockNoBlockId()
    {
        $block = new ActionsBlock([]);
        $this->assertSame(Block::TYPE_ACTIONS, $block->getType());

        $this->assertEquals([
            'type' => Block::TYPE_ACTIONS,
        ], $block->toArray());
    }
}
