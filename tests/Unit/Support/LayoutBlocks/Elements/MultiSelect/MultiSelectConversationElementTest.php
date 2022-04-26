<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\FilterObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectConversationElement;
use Nwilging\LaravelSlackBotTests\TestCase;
use Nwilging\LaravelSlackBotTests\Traits\BasicMultiSelectTests;

class MultiSelectConversationElementTest extends TestCase
{
    use BasicMultiSelectTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = MultiSelectConversationElement::class;
        $this->expectedType = Element::TYPE_MULTI_SELECT_CONVERSATIONS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $element = new MultiSelectConversationElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_CONVERSATIONS,
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

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $initialConversations = ['channel1', 'channel2'];

        $element = new MultiSelectConversationElement($actionId, $placeholder);

        $element->withInitialConversations($initialConversations);
        $element->maxSelectedItems(5);
        $element->withFocusOnLoad();
        $element->defaultToCurrent();
        $element->withConfirmationDialog($confirmationDialogObject);
        $element->withFilter($filter);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_CONVERSATIONS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'focus_on_load' => true,
            'max_selected_items' => 5,
            'initial_conversations' => $initialConversations,
            'default_to_current_conversation' => true,
            'confirm' => $expectedConfirmationDialogArray,
            'filter' => $expectedFilterArray,
        ], $element->toArray());
    }
}
