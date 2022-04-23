<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenuUserElement;
use Tests\TestCase;
use Tests\Traits\BasicSelectMenuTests;

class SelectMenuUserElementTest extends TestCase
{
    use BasicSelectMenuTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = SelectMenuUserElement::class;
        $this->expectedType = Element::TYPE_SELECT_MENU_USERS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';
        $element = new SelectMenuUserElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_USERS,
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
        $element = new SelectMenuUserElement($actionId, $placeholder);

        $element->withInitialOption('username');
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_USERS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'initial_user' => 'username',
            'focus_on_load' => true,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }
}
