<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MultiSelectElementCompatibility;

/**
 * Multi Select Static Options Element
 * @see https://api.slack.com/reference/block-kit/block-elements#static_multi_select
 */
class MultiSelectStaticElement extends MultiSelect
{
    use MergesArrays;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    /**
     * @var OptionObject[]|null
     */
    protected ?array $initialOptions = null;

    /**
     * @param string $actionId
     * @param TextObject $placeholder
     * @param OptionObject[] $options
     */
    public function __construct(string $actionId, TextObject $placeholder, array $options)
    {
        parent::__construct($actionId, $placeholder);
        $this->options = $options;
    }

    /**
     * An array of options that exactly match one or more of the options within options.
     * These options will be selected when the menu initially loads.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#static_multi_select__fields
     *
     * @param OptionObject[] $options
     * @return $this
     */
    public function withInitialOptions(array $options): self
    {
        $this->initialOptions = $options;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_MULTI_SELECT_STATIC;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
            'initial_options' => ($this->initialOptions) ? array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->initialOptions) : null,
        ]);
    }
}
