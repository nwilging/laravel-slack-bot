<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Time Picker Element
 * @see https://api.slack.com/reference/block-kit/block-elements#timepicker
 */
class TimePickerElement extends Element
{
    use MergesArrays, HasActionId, WithFocusOnLoad, WithConfirmationDialog;

    protected TextObject $placeholder;

    protected ?string $initialTime = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        $this->actionId = $actionId;
        $this->placeholder = $placeholder;
    }

    /**
     * The initial time that is selected when the element is loaded.
     * This should be in the format HH:mm, where HH is the 24-hour format of an hour (00 to 23) and mm is minutes
     * with leading zeros (00 to 59), for example 22:25 for 10:25pm.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#timepicker__fields
     *
     * @param string $initialTime
     * @return $this
     */
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
        return $this->toMergedArray($this->mergeConfirmationDialog([
            'action_id' => $this->actionId,
            'placeholder' => $this->placeholder->toArray(),
            'initial_time' => $this->initialTime,
            'focus_on_load' => $this->focusOnLoad,
        ]));
    }
}
