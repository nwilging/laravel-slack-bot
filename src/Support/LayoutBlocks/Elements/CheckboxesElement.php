<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;

class CheckboxesElement extends Element
{
    use MergesArrays, WithFocusOnLoad;

    protected string $actionId;

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
     * @param OptionObject[] $options
     */
    public function __construct(string $actionId, array $options)
    {
        $this->actionId = $actionId;
        $this->options = $options;
    }

    /**
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
        return static::TYPE_CHECKBOXES;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_ACTIONS,
            Block::TYPE_SECTION,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'action_id' => $this->actionId,
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
