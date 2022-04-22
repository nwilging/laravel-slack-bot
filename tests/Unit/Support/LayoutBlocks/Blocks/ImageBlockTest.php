<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\ImageBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use PHPUnit\Framework\TestCase;

class ImageBlockTest extends TestCase
{
    public function testBlock()
    {
        $expectedTextObjectArray = ['key' => 'val'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $block = new ImageBlock('https://example.com', 'test alt text', 'block-id');
        $this->assertSame(Block::TYPE_IMAGE, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_IMAGE,
            'block_id' => 'block-id',
            'image_url' => 'https://example.com',
            'alt_text' => 'test alt text',
        ], $block->toArray());
    }

    public function testBlockNoBlockId()
    {
        $block = new ImageBlock('https://example.com', 'test alt text');
        $this->assertSame(Block::TYPE_IMAGE, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_IMAGE,
            'image_url' => 'https://example.com',
            'alt_text' => 'test alt text',
        ], $block->toArray());
    }

    public function testBlockWithTitle()
    {
        $expectedTextObjectArray = ['key' => 'val'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $block = new ImageBlock('https://example.com', 'test alt text');
        $block->withTitle($textObject);

        $this->assertSame(Block::TYPE_IMAGE, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_IMAGE,
            'image_url' => 'https://example.com',
            'alt_text' => 'test alt text',
            'title' => $expectedTextObjectArray,
        ], $block->toArray());
    }
}
