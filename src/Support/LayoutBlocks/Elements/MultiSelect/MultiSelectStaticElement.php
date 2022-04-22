<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MultiSelectElementCompatibility;

class MultiSelectStaticElement extends Element
{
    use MergesArrays, MultiSelectElementCompatibility, WithFocusOnLoad;

    protected string $actionId;

    protected TextObject $placeholder;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    /**
     * @var OptionObject[]|null
     */
    protected ?array $initialOptions = null;

    protected ?int $maxSelectedItems = null;

    /**
     * @param string $actionId
     * @param TextObject $placeholder
     * @param OptionObject[] $options
     */
    public function __construct(string $actionId, TextObject $placeholder, array $options)
    {
        $this->actionId = $actionId;
        $this->placeholder = $placeholder;
        $this->options = $options;
    }

    public function maxSelectedItems(int $maxSelectedItems): self
    {
        $this->maxSelectedItems = $maxSelectedItems;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_MULTI_SELECT_STATIC;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'action_id' => $this->actionId,
            'placeholder' => $this->placeholder->toArray(),
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
            'initial_options' => ($this->initialOptions) ? array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->initialOptions) : null,
            'focus_on_load' => $this->focusOnLoad,
        ]);
    }
}
