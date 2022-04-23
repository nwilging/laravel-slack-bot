<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class SelectMenuPublicChannelElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    protected ?bool $responseUrlEnabled = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
        $this->initialOptionKeyName = 'initial_channel';
    }

    public function withResponseUrlEnabled(bool $responseUrlEnabled = true): self
    {
        $this->responseUrlEnabled = $responseUrlEnabled;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_SELECT_MENU_CHANNELS;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption([
            'response_url_enabled' => $this->responseUrlEnabled,
        ]));
    }
}
