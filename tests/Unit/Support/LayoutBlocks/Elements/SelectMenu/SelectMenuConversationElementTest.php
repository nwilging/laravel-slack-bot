<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\FilterObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenuConversationElement;
use Tests\TestCase;
use Tests\Traits\BasicSelectMenuTests;

class SelectMenuConversationElementTest extends TestCase
{
    use BasicSelectMenuTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = SelectMenuConversationElement::class;
        $this->expectedType = Element::TYPE_SELECT_MENU_CONVERSATIONS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';
        $element = new SelectMenuConversationElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_CONVERSATIONS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedConfirmationDialogArray = ['key2' => 'value2'];
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $expectedFilterArray = ['filter' => 'value'];
        $filter = \Mockery::mock(FilterObject::class);
        $filter->shouldReceive('toArray')->andReturn($expectedFilterArray);

        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';
        $element = new SelectMenuConversationElement($actionId, $placeholder);

        $element->withInitialOption('general');
        $element->withFocusOnLoad();
        $element->withResponseUrlEnabled();
        $element->defaultToCurrent();
        $element->withConfirmationDialog($confirmationDialogObject);
        $element->withFilter($filter);

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_CONVERSATIONS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'initial_conversation' => 'general',
            'focus_on_load' => true,
            'response_url_enabled' => true,
            'default_to_current_conversation' => true,
            'confirm' => $expectedConfirmationDialogArray,
            'filter' => $expectedFilterArray,
        ], $element->toArray());
    }
}
