<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\TimePickerElement;
use Nwilging\LaravelSlackBotTests\TestCase;

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
        $expectedConfirmationDialogArray = ['key2' => 'value2'];
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';

        $element = new TimePickerElement($actionId, $placeholder);

        $element->withFocusOnLoad();
        $element->withInitialTime('10:00:00');
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_TIME_PICKER,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'focus_on_load' => true,
            'initial_time' => '10:00:00',
            'confirm' => $expectedConfirmationDialogArray,
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
