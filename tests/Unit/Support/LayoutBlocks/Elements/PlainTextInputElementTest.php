<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\PlainTextInputElement;
use Nwilging\LaravelSlackBotTests\TestCase;

class PlainTextInputElementTest extends TestCase
{
    public function testElement()
    {
        $actionId = 'action-id';

        $element = new PlainTextInputElement($actionId);

        $this->assertEquals([
            'type' => Element::TYPE_PLAIN_TEXT_INPUT,
            'action_id' => $actionId,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $actionId = 'action-id';

        $element = new PlainTextInputElement($actionId);

        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $element->multiline();
        $element->withMinLength(1);
        $element->withMaxLength(10);
        $element->withInitialValue('initial value');
        $element->withFocusOnLoad();

        $this->assertEquals([
            'type' => Element::TYPE_PLAIN_TEXT_INPUT,
            'action_id' => $actionId,
            'initial_value' => 'initial value',
            'multiline' => true,
            'min_length' => 1,
            'max_length' => 10,
            'focus_on_load' => true,
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $actionId = 'action-id';
        $element = new PlainTextInputElement($actionId);

        $this->assertEquals([
            Block::TYPE_INPUT,
        ], $element->compatibleWith());
    }
}
