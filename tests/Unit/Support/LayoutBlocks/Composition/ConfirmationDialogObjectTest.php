<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBotTests\TestCase;

class ConfirmationDialogObjectTest extends TestCase
{
    public function testObject()
    {
        $expectedTitleArray = ['k1' => 'v1'];
        $expectedTextArray = ['k2' => 'v2'];
        $expectedConfirmArray = ['k3' => 'v3'];
        $expectedDenyArray = ['k4' => 'v4'];

        $title = \Mockery::mock(TextObject::class);
        $text = \Mockery::mock(TextObject::class);
        $confirm = \Mockery::mock(TextObject::class);
        $deny = \Mockery::mock(TextObject::class);

        $title->shouldReceive('toArray')->andReturn($expectedTitleArray);
        $text->shouldReceive('toArray')->andReturn($expectedTextArray);
        $confirm->shouldReceive('toArray')->andReturn($expectedConfirmArray);
        $deny->shouldReceive('toArray')->andReturn($expectedDenyArray);

        $object = new ConfirmationDialogObject($title, $text, $confirm, $deny);

        $this->assertEquals([
            'title' => $expectedTitleArray,
            'text' => $expectedTextArray,
            'confirm' => $expectedConfirmArray,
            'deny' => $expectedDenyArray,
        ], $object->toArray());
    }

    public function testObjectWithButtonPrimary()
    {
        $expectedTitleArray = ['k1' => 'v1'];
        $expectedTextArray = ['k2' => 'v2'];
        $expectedConfirmArray = ['k3' => 'v3'];
        $expectedDenyArray = ['k4' => 'v4'];

        $title = \Mockery::mock(TextObject::class);
        $text = \Mockery::mock(TextObject::class);
        $confirm = \Mockery::mock(TextObject::class);
        $deny = \Mockery::mock(TextObject::class);

        $title->shouldReceive('toArray')->andReturn($expectedTitleArray);
        $text->shouldReceive('toArray')->andReturn($expectedTextArray);
        $confirm->shouldReceive('toArray')->andReturn($expectedConfirmArray);
        $deny->shouldReceive('toArray')->andReturn($expectedDenyArray);

        $object = new ConfirmationDialogObject($title, $text, $confirm, $deny);
        $object->confirmButtonPrimary();

        $this->assertEquals([
            'title' => $expectedTitleArray,
            'text' => $expectedTextArray,
            'confirm' => $expectedConfirmArray,
            'deny' => $expectedDenyArray,
            'style' => 'primary',
        ], $object->toArray());
    }

    public function testObjectWithButtonDanger()
    {
        $expectedTitleArray = ['k1' => 'v1'];
        $expectedTextArray = ['k2' => 'v2'];
        $expectedConfirmArray = ['k3' => 'v3'];
        $expectedDenyArray = ['k4' => 'v4'];

        $title = \Mockery::mock(TextObject::class);
        $text = \Mockery::mock(TextObject::class);
        $confirm = \Mockery::mock(TextObject::class);
        $deny = \Mockery::mock(TextObject::class);

        $title->shouldReceive('toArray')->andReturn($expectedTitleArray);
        $text->shouldReceive('toArray')->andReturn($expectedTextArray);
        $confirm->shouldReceive('toArray')->andReturn($expectedConfirmArray);
        $deny->shouldReceive('toArray')->andReturn($expectedDenyArray);

        $object = new ConfirmationDialogObject($title, $text, $confirm, $deny);
        $object->confirmButtonDanger();

        $this->assertEquals([
            'title' => $expectedTitleArray,
            'text' => $expectedTextArray,
            'confirm' => $expectedConfirmArray,
            'deny' => $expectedDenyArray,
            'style' => 'danger',
        ], $object->toArray());
    }
}
