<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\SectionBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use PHPUnit\Framework\TestCase;

class SectionBlockTest extends TestCase
{
    public function testBlockWithText()
    {
        $expectedTextObjectArray = ['key' => 'val'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $block = new SectionBlock();
        $block->withText($textObject);

        $this->assertSame(Block::TYPE_SECTION, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_SECTION,
            'text' => $expectedTextObjectArray,
        ], $block->toArray());
    }

    public function testBlockWithFields()
    {
        $expectedTextObject1Array = ['key' => 'val'];
        $expectedTextObject2Array = ['key' => 'val'];
        $expectedTextObject3Array = ['key' => 'val'];

        $textObject1 = \Mockery::mock(TextObject::class);
        $textObject1->shouldReceive('toArray')->andReturn($expectedTextObject1Array);

        $textObject2 = \Mockery::mock(TextObject::class);
        $textObject2->shouldReceive('toArray')->andReturn($expectedTextObject2Array);

        $textObject3 = \Mockery::mock(TextObject::class);
        $textObject3->shouldReceive('toArray')->andReturn($expectedTextObject3Array);

        $block = new SectionBlock();
        $block->withFields([$textObject1, $textObject2, $textObject3]);

        $this->assertSame(Block::TYPE_SECTION, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_SECTION,
            'fields' => [$expectedTextObject1Array, $expectedTextObject2Array, $expectedTextObject3Array],
        ], $block->toArray());
    }

    public function testBlockWithAccessory()
    {
        $expectedTextObjectArray = ['key' => 'val'];
        $expectedElementArray = ['key2' => 'val2'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $element = \Mockery::mock(Element::class);
        $element->shouldReceive('toArray')->andReturn($expectedElementArray);

        $block = new SectionBlock('block-id');
        $block->withText($textObject);
        $block->withAccessory($element);

        $this->assertSame(Block::TYPE_SECTION, $block->getType());
        $this->assertEquals([
            'type' => Block::TYPE_SECTION,
            'text' => $expectedTextObjectArray,
            'accessory' => $expectedElementArray,
            'block_id' => 'block-id',
        ], $block->toArray());
    }
}
