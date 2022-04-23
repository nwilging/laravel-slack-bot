<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Radio Button Group Element
 * @see https://api.slack.com/reference/block-kit/block-elements#radio
 */
class RadioButtonGroupElement extends Element
{
    use MergesArrays, HasActionId, WithFocusOnLoad, WithConfirmationDialog;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    protected ?OptionObject $initialOption = null;

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
     * An option object that exactly matches one of the options within options.
     * This option will be selected when the radio button group initially loads.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#radio__fields
     *
     * @param OptionObject $option
     * @return $this
     */
    public function withInitialOption(OptionObject $option): self
    {
        $this->initialOption = $option;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_RADIO_BUTTON_GROUP;
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
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
            'initial_option' => ($this->initialOption) ? $this->initialOption->toArray() : null,
            'focus_on_load' => $this->focusOnLoad,
        ]));
    }
}
