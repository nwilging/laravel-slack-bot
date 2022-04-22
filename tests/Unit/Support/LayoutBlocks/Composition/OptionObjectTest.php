<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Tests\TestCase;

class OptionObjectTest extends TestCase
{
    public function testObject()
    {
        $text = 'test text';
        $value = 'test value';

        $option = new OptionObject($text, $value);

        $this->assertEquals([
            'text' => $text,
            'value' => $value,
        ], $option->toArray());
    }

    public function testObjectWithOptions()
    {
        $text = 'test text';
        $value = 'test value';

        $option = new OptionObject($text, $value);

        $expectedTextObjectArray = ['key' => 'value'];

        $descriptionTextObject = \Mockery::mock(TextObject::class);
        $descriptionTextObject->shouldReceive('toArray')->andReturn($expectedTextObjectArray);

        $option->withDescription($descriptionTextObject);
        $option->withUrl('https://example.com');

        $this->assertEquals([
            'text' => $text,
            'value' => $value,
            'url' => 'https://example.com',
            'description' => $expectedTextObjectArray,
        ], $option->toArray());
    }
}
