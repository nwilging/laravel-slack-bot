<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectUserElement;
use Tests\TestCase;
use Tests\Traits\BasicMultiSelectTests;

class MultiSelectUserElementTest extends TestCase
{
    use BasicMultiSelectTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = MultiSelectUserElement::class;
        $this->expectedType = Element::TYPE_MULTI_SELECT_USERS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $element = new MultiSelectUserElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_USERS,
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

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $initialUsers = ['user1', 'user2'];

        $element = new MultiSelectUserElement($actionId, $placeholder);

        $element->withInitialUsers($initialUsers);
        $element->maxSelectedItems(5);
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_USERS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'focus_on_load' => true,
            'max_selected_items' => 5,
            'initial_users' => $initialUsers,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }
}
