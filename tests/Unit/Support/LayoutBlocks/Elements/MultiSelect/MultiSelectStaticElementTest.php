<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectStaticElement;
use Tests\TestCase;
use Tests\Traits\BasicMultiSelectTests;

class MultiSelectStaticElementTest extends TestCase
{
    use BasicMultiSelectTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = MultiSelectStaticElement::class;
        $this->additionalSetupArgs = [[]];
        $this->expectedType = Element::TYPE_MULTI_SELECT_STATIC;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'val'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $expectedOption1Array = ['o1' => 'k1'];
        $expectedOption2Array = ['o2' => 'k2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $element = new MultiSelectStaticElement($actionId, $placeholder, [$option1, $option2]);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_STATIC,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedConfirmationDialogArray = ['key2' => 'value2'];
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $expectedPlaceholderArray = ['key' => 'val'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $expectedOption1Array = ['o1' => 'k1'];
        $expectedOption2Array = ['o2' => 'k2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $element = new MultiSelectStaticElement($actionId, $placeholder, [$option1, $option2]);

        $element->withFocusOnLoad();
        $element->withInitialOptions([$option1, $option2]);
        $element->maxSelectedItems(1);
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_STATIC,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
            'initial_options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
            'focus_on_load' => true,
            'max_selected_items' => 1,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }
}
