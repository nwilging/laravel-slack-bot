<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\ContextBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Tests\TestCase;

class ContextBlockTest extends TestCase
{
    public function testBlock()
    {
        $expectedTextElementArray = ['key' => 'val'];
        $expectedElementArray = ['key2' => 'val2'];

        $textBlockElement = \Mockery::mock(TextObject::class);
        $textBlockElement->shouldReceive('toArray')->andReturn($expectedTextElementArray);

        $element = \Mockery::mock(Element::class);
        $element->shouldReceive('toArray')->andReturn($expectedElementArray);

        $block = new ContextBlock([$textBlockElement], [$element], 'block-id');
        $this->assertSame(Block::TYPE_CONTEXT, $block->getType());

        $this->assertEquals([
            'type' => Block::TYPE_CONTEXT,
            'block_id' => 'block-id',
            'elements' => [$expectedElementArray, $expectedTextElementArray]
        ], $block->toArray());
    }

    public function testBlockNoBlockId()
    {
        $block = new ContextBlock([], []);
        $this->assertSame(Block::TYPE_CONTEXT, $block->getType());

        $this->assertEquals([
            'type' => Block::TYPE_CONTEXT,
        ], $block->toArray());
    }
}
