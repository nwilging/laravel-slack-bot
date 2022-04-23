<?php
declare(strict_types=1);

namespace Tests\Traits;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu\SelectMenu;

trait BasicSelectMenuTests
{
    protected string $elementClass;

    protected string $expectedType;

    protected array $additionalSetupArgs = [];

    public function testElementCompatibleWith()
    {
        /** @var SelectMenu $element */
        $element = new $this->elementClass('action-id', \Mockery::mock(TextObject::class), ...$this->additionalSetupArgs);
        $this->assertEquals([
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
            Block::TYPE_INPUT,
        ], $element->compatibleWith());
    }

    public function testElementType()
    {
        /** @var SelectMenu $element */
        $element = new $this->elementClass('action-id', \Mockery::mock(TextObject::class), ...$this->additionalSetupArgs);
        $this->assertSame($this->expectedType, $element->getType());
    }
}
