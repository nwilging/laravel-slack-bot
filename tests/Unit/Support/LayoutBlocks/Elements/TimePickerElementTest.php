<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\TimePickerElement;
use Tests\TestCase;

class TimePickerElementTest extends TestCase
{
    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';

        $element = new TimePickerElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_TIME_PICKER,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';

        $element = new TimePickerElement($actionId, $placeholder);

        $element->withFocusOnLoad();
        $element->withInitialTime('10:00:00');

        $this->assertEquals([
            'type' => Element::TYPE_TIME_PICKER,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'focus_on_load' => true,
            'initial_time' => '10:00:00',
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $element = new TimePickerElement('action-id', \Mockery::mock(TextObject::class));
        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
            Block::TYPE_INPUT,
        ], $element->compatibleWith());
    }
}
