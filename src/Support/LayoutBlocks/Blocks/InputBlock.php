<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Input Block
 * @see https://api.slack.com/reference/block-kit/blocks#input
 */
class InputBlock extends Block
{
    use MergesArrays;

    protected TextObject $label;

    protected Element $element;

    protected ?bool $dispatchAction = null;

    protected ?TextObject $hint = null;

    protected ?bool $optional = null;

    public function __construct(TextObject $label, Element $element, ?string $blockId = null)
    {
        parent::__construct($blockId);

        $this->label = $label;
        $this->element = $element;
    }

    public function dispatchAction(bool $dispatchAction = true): self
    {
        $this->dispatchAction = $dispatchAction;
        return $this;
    }

    public function withHint(TextObject $text): self
    {
        $this->hint = $text;
        return $this;
    }

    public function optional(bool $optional = true): self
    {
        $this->optional = $optional;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_INPUT;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'label' => $this->label->toArray(),
            'element' => $this->element->toArray(),
            'hint' => ($this->hint) ? $this->hint->toArray() : null,
            'dispatch_action' => $this->dispatchAction,
            'optional' => $this->optional,
        ]);
    }
}
