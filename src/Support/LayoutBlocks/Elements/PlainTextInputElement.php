<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Plain Text Input Element
 * @see https://api.slack.com/reference/block-kit/block-elements#input
 */
class PlainTextInputElement extends Element
{
    use MergesArrays, WithFocusOnLoad, HasActionId;

    protected ?TextObject $placeholder = null;

    protected ?string $initialValue = null;

    protected ?bool $multiline = null;

    protected ?int $minLength = null;

    protected ?int $maxLength = null;

    public function __construct(string $actionId)
    {
        $this->actionId = $actionId;
    }

    /**
     * The initial value in the plain-text input when it is loaded.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#input__fields
     *
     * @param string $initialValue
     * @return $this
     */
    public function withInitialValue(string $initialValue): self
    {
        $this->initialValue = $initialValue;
        return $this;
    }

    /**
     * The minimum length of input that the user must provide. If the user provides less, they will receive an error.
     * Maximum value is 3000.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#input__fields
     *
     * @param int $minLength
     * @return $this
     */
    public function withMinLength(int $minLength): self
    {
        $this->minLength = $minLength;
        return $this;
    }

    /**
     * The maximum length of input that the user can provide. If the user provides more, they will receive an error.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#input__fields
     *
     * @param int $maxLength
     * @return $this
     */
    public function withMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    /**
     * Indicates whether the input will be a single line (false) or a larger textarea (true). Defaults to false.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#input__fields
     *
     * @param bool $multiline
     * @return $this
     */
    public function multiline(bool $multiline = true): self
    {
        $this->multiline = $multiline;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_PLAIN_TEXT_INPUT;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_INPUT,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'action_id' => $this->actionId,
            'placeholder' => ($this->placeholder) ? $this->placeholder->toArray() : null,
            'initial_value' => $this->initialValue,
            'multiline' => $this->multiline,
            'min_length' => $this->minLength,
            'max_length' => $this->maxLength,
            'focus_on_load' => $this->focusOnLoad,
        ]);
    }
}
