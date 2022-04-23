<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\DispatchActionConfigurationObject;
use Tests\TestCase;

class DispatchActionConfigurationObjectTest extends TestCase
{
    public function testObject()
    {
        $triggerActionsOn = ['on_enter_pressed', 'on_character_entered'];
        $object = new DispatchActionConfigurationObject();

        $object->onEnterPressed();
        $object->onCharacterEntered();

        $this->assertEquals([
            'trigger_actions_on' => $triggerActionsOn,
        ], $object->toArray());
    }

    public function testObjectNoTriggers()
    {
        $object = new DispatchActionConfigurationObject();
        $this->assertEquals([], $object->toArray());
    }
}
