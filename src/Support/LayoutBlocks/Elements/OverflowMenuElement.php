<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Overflow Menu Element
 * @see https://api.slack.com/reference/block-kit/block-elements#overflow
 */
class OverflowMenuElement extends Element
{
    use MergesArrays, HasActionId, WithConfirmationDialog;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    public function __construct(string $actionId, array $options)
    {
        $this->actionId = $actionId;
        $this->options = $options;
    }

    public function getType(): string
    {
        return static::TYPE_OVERFLOW_MENU;
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
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
        ]));
    }
}
