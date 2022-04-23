<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\DatePickerElement;
use Tests\TestCase;

class DatePickerElementTest extends TestCase
{
    public function testElement()
    {
        $actionId = 'action-id';

        $element = new DatePickerElement($actionId);

        $this->assertEquals([
            'type' => Element::TYPE_DATEPICKER,
            'action_id' => $actionId,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $actionId = 'action-id';
        $initialDate = '2022-01-01';

        $element = new DatePickerElement($actionId, $initialDate);

        $expectedPlaceholderTextArray = ['key' => 'val'];
        $expectedConfirmationDialogArray = ['key2' => 'value2'];

        $placeholderTextObject = \Mockery::mock(TextObject::class);
        $confirmationDialogObject = \Mockery::mock(ConfirmationDialogObject::class);

        $placeholderTextObject->shouldReceive('toArray')->andReturn($expectedPlaceholderTextArray);
        $confirmationDialogObject->shouldReceive('toArray')->andReturn($expectedConfirmationDialogArray);

        $element->withPlaceholder($placeholderTextObject);
        $element->withFocusOnLoad();
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_DATEPICKER,
            'action_id' => $actionId,
            'initial_date' => $initialDate,
            'placeholder' => $expectedPlaceholderTextArray,
            'focus_on_load' => true,
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $element = new DatePickerElement('');
        $this->assertSame([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
        ], $element->compatibleWith());
    }
}
