<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\HeaderBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Tests\TestCase;

class HeaderBlockTest extends TestCase
{
    public function testBlock()
    {
        $expectedTextObjectArray = ['key' => 'val'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $block = new HeaderBlock($textObject, 'block-id');
        $this->assertSame(Block::TYPE_HEADER, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_HEADER,
            'block_id' => 'block-id',
            'text' => $expectedTextObjectArray,
        ], $block->toArray());
    }

    public function testBlockNoBlockId()
    {
        $expectedTextObjectArray = ['key' => 'val'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $block = new HeaderBlock($textObject);
        $this->assertSame(Block::TYPE_HEADER, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_HEADER,
            'text' => $expectedTextObjectArray,
        ], $block->toArray());
    }
}
