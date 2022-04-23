<?php
declare(strict_types=1);

namespace Tests\Traits;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;

trait BasicMultiSelectTests
{
    protected string $elementClass;

    protected string $expectedType;

    protected array $additionalSetupArgs = [];

    public function testElementCompatibleWith()
    {
        /** @var Element $element */
        $element = new $this->elementClass('action-id', \Mockery::mock(TextObject::class), ...$this->additionalSetupArgs);
        $this->assertEquals([
            Block::TYPE_SECTION,
        ], $element->compatibleWith());
    }

    public function testElementType()
    {
        /** @var Element $element */
        $element = new $this->elementClass('action-id', \Mockery::mock(TextObject::class), ...$this->additionalSetupArgs);
        $this->assertSame($this->expectedType, $element->getType());
    }
}
