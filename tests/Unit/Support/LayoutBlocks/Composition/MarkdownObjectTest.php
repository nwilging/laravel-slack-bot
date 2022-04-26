<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\MarkdownObject;
use Nwilging\LaravelSlackBotTests\TestCase;

class MarkdownObjectTest extends TestCase
{
    public function testObject()
    {
        $text = 'test text';
        $object = new MarkdownObject($text);

        $this->assertEquals([
            'type' => 'mrkdwn',
            'text' => 'test text',
        ], $object->toArray());
    }

    public function testObjectWithOptions()
    {
        $text = 'test text';
        $object = new MarkdownObject($text);

        $object->verbatim();
        $object->escapeEmojis();

        $this->assertEquals([
            'type' => 'mrkdwn',
            'text' => 'test text',
            'emoji' => true,
            'verbatim' => true,
        ], $object->toArray());
    }
}
