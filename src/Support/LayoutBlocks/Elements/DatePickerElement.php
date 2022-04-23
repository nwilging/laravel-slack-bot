<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class DatePickerElement extends Element
{
    use WithFocusOnLoad, MergesArrays, WithConfirmationDialog;

    protected string $actionId;

    protected ?string $initialDate;

    protected ?TextObject $placeholder = null;

    public function __construct(string $actionId, ?string $initialDate = null)
    {
        $this->actionId = $actionId;
        $this->initialDate = $initialDate;
    }

    public function withPlaceholder(TextObject $textObject): self
    {
        $this->placeholder = $textObject;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_DATEPICKER;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeConfirmationDialog([
            'action_id' => $this->actionId,
            'initial_date' => $this->initialDate,
            'placeholder' => ($this->placeholder) ? $this->placeholder->toArray() : null,
            'focus_on_load' => $this->focusOnLoad,
        ]));
    }
}
