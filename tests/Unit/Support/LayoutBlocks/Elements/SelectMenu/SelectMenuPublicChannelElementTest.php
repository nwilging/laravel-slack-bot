<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenuPublicChannelElement;
use Tests\TestCase;
use Tests\Traits\BasicSelectMenuTests;

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
        $expectedPlaceholderArray = ['key' => 'value'];

        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $actionId = 'action-id';
        $element = new SelectMenuPublicChannelElement($actionId, $placeholder);

        $element->withInitialOption('general');
        $element->withFocusOnLoad();
        $element->withResponseUrlEnabled();

        $this->assertEquals([
            'type' => Element::TYPE_SELECT_MENU_CHANNELS,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'initial_channel' => 'general',
            'focus_on_load' => true,
            'response_url_enabled' => true,
        ], $element->toArray());
    }
}
