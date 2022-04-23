<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Multi Select Public Channels Element
 * @see https://api.slack.com/reference/block-kit/block-elements#channel_multi_select
 */
class MultiSelectPublicChannelElement extends MultiSelect
{
    use MergesArrays;

    protected ?array $initialChannels = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    /**
     * An array of one or more IDs of any valid public channel to be pre-selected when the menu loads.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#channel_multi_select__fields
     *
     * @param string[] $initialChannels
     * @return $this
     */
    public function withInitialChannels(array $initialChannels): self
    {
        $this->initialChannels = $initialChannels;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_MULTI_SELECT_CHANNELS;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'initial_channels' => $this->initialChannels,
        ]);
    }
}
