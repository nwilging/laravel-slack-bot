<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\CheckboxesElement;
use Tests\TestCase;

class CheckboxesElementTest extends TestCase
{
    public function testElement()
    {
        $actionId = 'action-id';

        $expectedOption1Array = ['key' => 'val'];
        $expectedOption2Array = ['key2' => 'val2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $element = new CheckboxesElement($actionId, [$option1, $option2]);

        $this->assertEquals([
            'type' => Element::TYPE_CHECKBOXES,
            'action_id' => $actionId,
            'options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
        ], $element->toArray());
    }

    public function testElementWithInitialOptions()
    {
        $actionId = 'action-id';

        $expectedConfirmationDialogArray = ['key2' => 'value2'];
        $expectedOption1Array = ['key' => 'val'];
        $expectedOption2Array = ['key2' => 'val2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $element = new CheckboxesElement($actionId, [$option1, $option2]);

        $element->withInitialOptions([$option1, $option2]);
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_CHECKBOXES,
            'action_id' => $actionId,
            'options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
            'initial_options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
            'focus_on_load' => true,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $element = new CheckboxesElement('', []);
        $this->assertSame([
            Block::TYPE_ACTIONS,
            Block::TYPE_SECTION,
        ], $element->compatibleWith());
    }
}
