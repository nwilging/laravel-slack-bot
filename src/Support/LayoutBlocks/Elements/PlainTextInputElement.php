<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

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

    public function withInitialValue(string $initialValue): self
    {
        $this->initialValue = $initialValue;
        return $this;
    }

    public function withMinLength(int $minLength): self
    {
        $this->minLength = $minLength;
        return $this;
    }

    public function withMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;
        return $this;
    }

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
