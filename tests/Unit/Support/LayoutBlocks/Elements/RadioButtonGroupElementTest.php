<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\RadioButtonGroupElement;
use Tests\TestCase;

class RadioButtonGroupElementTest extends TestCase
{
    public function testElement()
    {
        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $actionId = 'action-id';

        $element = new RadioButtonGroupElement($actionId, [$option1, $option2]);

        $this->assertEquals([
            'type' => Element::TYPE_RADIO_BUTTON_GROUP,
            'action_id' => $actionId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedConfirmationDialogArray = ['key2' => 'value2'];
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $actionId = 'action-id';

        $element = new RadioButtonGroupElement($actionId, [$option1, $option2]);

        $element->withInitialOption($option1);
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_RADIO_BUTTON_GROUP,
            'action_id' => $actionId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
            'focus_on_load' => true,
            'initial_option' => $expectedOption1Array,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $actionId = 'action-id';
        $element = new RadioButtonGroupElement($actionId, []);

        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
            Block::TYPE_INPUT,
        ], $element->compatibleWith());
    }
}
