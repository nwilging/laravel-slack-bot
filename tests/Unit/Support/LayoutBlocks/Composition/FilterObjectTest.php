<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\FilterObject;
use Tests\TestCase;

class FilterObjectTest extends TestCase
{
    public function testObject()
    {
        $object = new FilterObject();
        $this->assertEmpty($object->toArray());
    }

    public function testObjectWithAllOptions()
    {
        $object = new FilterObject();

        $object->includeConversationTypes(['public', 'private']);
        $object->excludeExternalSharedChannels();
        $object->excludeBotUsers();

        $this->assertEquals([
            'include' => ['public', 'private'],
            'exclude_external_shared_channels' => true,
            'exclude_bot_users' => true,
        ], $object->toArray());
    }
}
