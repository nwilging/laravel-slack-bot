<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class TimePickerElement extends Element
{
    use MergesArrays, HasActionId, WithFocusOnLoad;

    protected TextObject $placeholder;

    protected ?string $initialTime = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        $this->actionId = $actionId;
        $this->placeholder = $placeholder;
    }

    public function withInitialTime(string $initialTime): self
    {
        $this->initialTime = $initialTime;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_TIME_PICKER;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
            Block::TYPE_INPUT,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'action_id' => $this->actionId,
            'placeholder' => $this->placeholder->toArray(),
            'initial_time' => $this->initialTime,
            'focus_on_load' => $this->focusOnLoad,
        ]);
    }
}
