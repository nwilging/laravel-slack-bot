<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBotTests\TestCase;

class InputBlockTest extends TestCase
{
    public function testBlock()
    {
        $expectedLabelArray = ['k1' => 'v1'];
        $expectedElementArray = ['k2' => 'v2'];

        $label = \Mockery::mock(TextObject::class);
        $element = \Mockery::mock(Element::class);

        $label->shouldReceive('toArray')->andReturn($expectedLabelArray);
        $element->shouldReceive('toArray')->andReturn($expectedElementArray);

        $block = new InputBlock($label, $element);

        $this->assertEquals([
            'type' => Block::TYPE_INPUT,
            'label' => $expectedLabelArray,
            'element' => $expectedElementArray,
        ], $block->toArray());
    }

    public function testBlockWithOptions()
    {
        $expectedLabelArray = ['k1' => 'v1'];
        $expectedHintArray = ['k2' => 'v2'];
        $expectedElementArray = ['k3' => 'v3'];

        $label = \Mockery::mock(TextObject::class);
        $hint = \Mockery::mock(TextObject::class);
        $element = \Mockery::mock(Element::class);

        $label->shouldReceive('toArray')->andReturn($expectedLabelArray);
        $hint->shouldReceive('toArray')->andReturn($expectedHintArray);
        $element->shouldReceive('toArray')->andReturn($expectedElementArray);

        $block = new InputBlock($label, $element, 'block-id');

        $block->withHint($hint);
        $block->dispatchAction();
        $block->optional();

        $this->assertEquals([
            'type' => Block::TYPE_INPUT,
            'label' => $expectedLabelArray,
            'element' => $expectedElementArray,
            'block_id' => 'block-id',
            'hint' => $expectedHintArray,
            'dispatch_action' => true,
            'optional' => true,
        ], $block->toArray());
    }
}
