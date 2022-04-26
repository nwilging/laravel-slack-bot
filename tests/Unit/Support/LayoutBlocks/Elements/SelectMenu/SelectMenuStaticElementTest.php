<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenuStaticElement;
use Nwilging\LaravelSlackBotTests\TestCase;
use Nwilging\LaravelSlackBotTests\Traits\BasicSelectMenuTests;

class SelectMenuStaticElementTest extends TestCase
{
    use BasicSelectMenuTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = SelectMenuStaticElement::class;
        $this->expectedType = Element::TYPE_SELECT_MENU_STATIC;
        $this->additionalSetupArgs = [[]];
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $actionId = 'action-id';
        $element = new SelectMenuStaticElement($actionId, $placeholder, [$option1, $option2]);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_STATIC,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'options' => [$expectedOption1Array, $expectedOption2Array],
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

        $expectedOption1Array = ['k1' => 'v1'];
        $expectedOption2Array = ['k2' => 'v2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $actionId = 'action-id';
        $element = new SelectMenuStaticElement($actionId, $placeholder, [$option1, $option2]);

        $element->withInitialOption($option1);
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_STATIC,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'options' => [$expectedOption1Array, $expectedOption2Array],
            'initial_option' => $expectedOption1Array,
            'focus_on_load' => true,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }
}
