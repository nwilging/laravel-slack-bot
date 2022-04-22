<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\ButtonElement;
use Tests\TestCase;

class ButtonElementTest extends TestCase
{
    public function testElement()
    {
        $expectedTextObjectArray = ['key' => 'value'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $actionId = 'action-id';

        $element = new ButtonElement($textObject, $actionId);

        $this->assertEquals([
            'type' => Element::TYPE_BUTTON,
            'text' => $expectedTextObjectArray,
            'action_id' => $actionId,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedTextObjectArray = ['key' => 'value'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $actionId = 'action-id';

        $element = new ButtonElement($textObject, $actionId);
        $element->withUrl('https://example.com', 'url value');
        $element->withAccessibilityLabel('accessibility label');

        $this->assertEquals([
            'type' => Element::TYPE_BUTTON,
            'text' => $expectedTextObjectArray,
            'action_id' => $actionId,
            'url' => 'https://example.com',
            'value' => 'url value',
            'accessibility_label' => 'accessibility label',
        ], $element->toArray());
    }

    public function testElementWithPrimaryStyle()
    {
        $expectedTextObjectArray = ['key' => 'value'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $actionId = 'action-id';

        $element = new ButtonElement($textObject, $actionId);

        $element->primary();
        $element->withUrl('https://example.com', 'url value');
        $element->withAccessibilityLabel('accessibility label');

        $this->assertEquals([
            'type' => Element::TYPE_BUTTON,
            'text' => $expectedTextObjectArray,
            'action_id' => $actionId,
            'url' => 'https://example.com',
            'value' => 'url value',
            'accessibility_label' => 'accessibility label',
            'style' => 'primary',
        ], $element->toArray());
    }

    public function testElementWithDangerStyle()
    {
        $expectedTextObjectArray = ['key' => 'value'];

        $textObject = \Mockery::mock(TextObject::class);
        $textObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $actionId = 'action-id';

        $element = new ButtonElement($textObject, $actionId);

        $element->danger();
        $element->withUrl('https://example.com', 'url value');
        $element->withAccessibilityLabel('accessibility label');

        $this->assertEquals([
            'type' => Element::TYPE_BUTTON,
            'text' => $expectedTextObjectArray,
            'action_id' => $actionId,
            'url' => 'https://example.com',
            'value' => 'url value',
            'accessibility_label' => 'accessibility label',
            'style' => 'danger',
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $element = new ButtonElement(\Mockery::mock(TextObject::class), '');
        $this->assertSame([
            Block::TYPE_ACTIONS,
            Block::TYPE_SECTION,
        ], $element->compatibleWith());
    }
}
