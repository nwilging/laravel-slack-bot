<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class SelectMenuConversationElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    protected ?bool $defaultToCurrent = null;

    protected ?bool $responseUrlEnabled = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
        $this->initialOptionKeyName = 'initial_conversation';
    }

    public function defaultToCurrent(bool $defaultToCurrent = true): self
    {
        $this->defaultToCurrent = $defaultToCurrent;
        return $this;
    }

    public function withResponseUrlEnabled(bool $responseUrlEnabled = true): self
    {
        $this->responseUrlEnabled = $responseUrlEnabled;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_SELECT_MENU_CONVERSATIONS;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption([
            'default_to_current_conversation' => $this->defaultToCurrent,
            'response_url_enabled' => $this->responseUrlEnabled,
        ]));
    }
}
