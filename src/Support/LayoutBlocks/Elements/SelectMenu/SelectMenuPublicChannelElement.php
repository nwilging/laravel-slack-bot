<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Select Menu Public Channels Element
 * @see https://api.slack.com/reference/block-kit/block-elements#channel_select
 */
class SelectMenuPublicChannelElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    protected ?bool $responseUrlEnabled = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
        $this->initialOptionKeyName = 'initial_channel';
    }

    /**
     * This field only works with menus in input blocks in modals.
     * When set to true, the view_submission payload from the menu's parent view will contain a response_url.
     * This response_url can be used for message responses.
     * The target channel for the message will be determined by the value of this select menu.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#channel_select__fields
     *
     * @param bool $responseUrlEnabled
     * @return $this
     */
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
