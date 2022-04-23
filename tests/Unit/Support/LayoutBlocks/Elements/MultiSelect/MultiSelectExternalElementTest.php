<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect\MultiSelectExternalElement;
use Tests\TestCase;
use Tests\Traits\BasicMultiSelectTests;

class MultiSelectExternalElementTest extends TestCase
{
    use BasicMultiSelectTests;

    public function setUp(): void
    {
        parent::setUp();

        $this->elementClass = MultiSelectExternalElement::class;
        $this->expectedType = Element::TYPE_MULTI_SELECT_EXTERNAL;
    }

    public function testElement()
    {
        $expectedPlaceholderArray = ['key' => 'val'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $element = new MultiSelectExternalElement($actionId, $placeholder);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_EXTERNAL,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
        ], $element->toArray());
    }

    public function testElementWithOptions()
    {
        $expectedPlaceholderArray = ['key' => 'val'];

        $actionId = 'action-id';
        $placeholder = \Mockery::mock(TextObject::class);
        $placeholder->shouldReceive('toArray')->andReturn($expectedPlaceholderArray);

        $expectedOption1Array = ['o1' => 'k1'];
        $expectedOption2Array = ['o2' => 'k2'];

        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $element = new MultiSelectExternalElement($actionId, $placeholder);

        $element->withMinQueryLength(5);
        $element->withFocusOnLoad();
        $element->withInitialOptions([$option1, $option2]);
        $element->maxSelectedItems(1);

        $this->assertEquals([
            'type' => Element::TYPE_MULTI_SELECT_EXTERNAL,
            'action_id' => $actionId,
            'placeholder' => $expectedPlaceholderArray,
            'initial_options' => [
                $expectedOption1Array,
                $expectedOption2Array,
            ],
            'focus_on_load' => true,
            'max_selected_items' => 1,
            'min_query_length' => 5,
        ], $element->toArray());
    }

    public function testCompatibleWith()
    {
        $actionId = 'action-id';
        $element = new MultiSelectExternalElement($actionId, \Mockery::mock(TextObject::class));

        $this->assertSame([
            Block::TYPE_SECTION,
        ], $element->compatibleWith());
    }
}
