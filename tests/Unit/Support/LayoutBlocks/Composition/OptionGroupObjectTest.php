<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionGroupObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBotTests\TestCase;

class OptionGroupObjectTest extends TestCase
{
    public function testObject()
    {
        $expectedLabelArray = ['k1' => 'v1'];
        $expectedOption1Array = ['k2' => 'v2'];
        $expectedOption2Array = ['k3' => 'v3'];

        $label = \Mockery::mock(TextObject::class);
        $option1 = \Mockery::mock(OptionObject::class);
        $option2 = \Mockery::mock(OptionObject::class);

        $label->shouldReceive('toArray')->andReturn($expectedLabelArray);
        $option1->shouldReceive('toArray')->andReturn($expectedOption1Array);
        $option2->shouldReceive('toArray')->andReturn($expectedOption2Array);

        $object = new OptionGroupObject($label, [$option1, $option2]);

        $this->assertEquals([
            'label' => $expectedLabelArray,
            'options' => [$expectedOption1Array, $expectedOption2Array],
        ], $object->toArray());
    }
}
