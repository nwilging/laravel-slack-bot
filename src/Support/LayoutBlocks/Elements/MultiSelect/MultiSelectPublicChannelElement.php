<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class MultiSelectPublicChannelElement extends MultiSelect
{
    use MergesArrays;

    protected ?array $initialChannels = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    /**
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
