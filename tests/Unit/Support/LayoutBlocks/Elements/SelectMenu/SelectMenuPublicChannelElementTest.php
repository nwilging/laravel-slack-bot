<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenuPublicChannelElement;
use Nwilging\LaravelSlackBotTests\TestCase;
use Nwilging\LaravelSlackBotTests\Traits\BasicSelectMenuTests;

class SelectMenuPublicChannelElementTest extends TestCase
{
    use BasicSelectMenuTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = SelectMenuPublicChannelElement::class;
        $this->expectedType = Element::TYPE_SELECT_MENU_CHANNELS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';
        $element = new SelectMenuPublicChannelElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_CHANNELS,
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
        $element = new SelectMenuPublicChannelElement($actionId, $placeholder);

        $element->withInitialOption('general');
        $element->withFocusOnLoad();
        $element->withResponseUrlEnabled();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_CHANNELS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'initial_channel' => 'general',
            'focus_on_load' => true,
            'response_url_enabled' => true,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }
}
