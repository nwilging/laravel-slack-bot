<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Date Picker Element
 * @see https://api.slack.com/reference/block-kit/block-elements#datepicker
 */
class DatePickerElement extends Element
{
    use WithFocusOnLoad, MergesArrays, WithConfirmationDialog;

    protected string $actionId;

    protected ?string $initialDate;

    protected ?TextObject $placeholder = null;

    /**
     * @see https://api.slack.com/reference/block-kit/block-elements#datepicker__fields
     *
     * @param string $actionId - An identifier for the action triggered when a menu option is selected
     * @param string|null $initialDate - The initial date that is selected when the element is loaded. This should be in the format YYYY-MM-DD.
     */
    public function __construct(string $actionId, ?string $initialDate = null)
    {
        $this->actionId = $actionId;
        $this->initialDate = $initialDate;
    }

    /**
     * A plain_text only text object that defines the placeholder text shown on the datepicker.
     * Maximum length for the text in this field is 150 characters.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#datepicker__fields
     *
     * @param TextObject $textObject
     * @return $this
     */
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
