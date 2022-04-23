<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectConversationElement;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectPublicChannelElement;
use Tests\TestCase;
use Tests\Traits\BasicMultiSelectTests;

class MultiSelectPublicChannelElementTest extends TestCase
{
    use BasicMultiSelectTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = MultiSelectPublicChannelElement::class;
        $this->expectedType = Element::TYPE_MULTI_SELECT_CHANNELS;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $element = new MultiSelectPublicChannelElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_CHANNELS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedPlaceholderArray = ['key' => 'value'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $initialChannels = ['channel1', 'channel2'];

        $element = new MultiSelectPublicChannelElement($actionId, $placeholder);

        $element->withInitialChannels($initialChannels);
        $element->maxSelectedItems(5);
        $element->withFocusOnLoad();

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_CHANNELS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'focus_on_load' => true,
            'max_selected_items' => 5,
            'initial_channels' => $initialChannels,
        ], $element->toArray());
    }
}
