<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\OverflowMenuElement;
use Nwilging\LaravelSlackBotTests\TestCase;

class OverflowMenuElementTest extends TestCase
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

        $element = new OverflowMenuElement($actionId, [$option1, $option2]);

        $this->assertEquals([
            'type' => Element::TYPE_OVERFLOW_MENU,
            'action_id' => $actionId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
        ], $element->toArray());

        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
        ], $element->compatibleWith());
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

        $element = new OverflowMenuElement($actionId, [$option1, $option2]);
        $element->withConfirmationDialog($confirmationDialogObject);

        $this->assertEquals([
            'type' => Element::TYPE_OVERFLOW_MENU,
            'action_id' => $actionId,
            'options' => [$expectedOption1Array, $expectedOption2Array],
            'confirm' => $expectedConfirmationDialogArray,
        ], $element->toArray());

        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
        ], $element->compatibleWith());
    }
}
