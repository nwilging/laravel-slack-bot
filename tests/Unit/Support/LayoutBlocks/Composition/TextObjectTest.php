<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Tests\TestCase;

class TextObjectTest extends TestCase
{
    public function testObject()
    {
        $text = 'test text';
        $object = new TextObject($text);

        $this->assertEquals([
            'type' => 'plain_text',
            'text' => 'test text',
        ], $object->toArray());
    }

    public function testObjectWithOptions()
    {
        $text = 'test text';
        $object = new TextObject($text);

        $object->verbatim();
        $object->escapeEmojis();

        $this->assertEquals([
            'type' => 'plain_text',
            'text' => 'test text',
            'emoji' => true,
        ], $object->toArray());
    }
}
