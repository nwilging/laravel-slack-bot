<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithFilter;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Select Menu Conversations Element
 * @see https://api.slack.com/reference/block-kit/block-elements#conversation_select
 */
class SelectMenuConversationElement extends SelectMenu
{
    use MergesArrays, HasInitialOption, WithFilter;

    protected ?bool $defaultToCurrent = null;

    protected ?bool $responseUrlEnabled = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
        $this->initialOptionKeyName = 'initial_conversation';
    }

    /**
     * Pre-populates the select menu with the conversation that the user was viewing when they opened
     * the modal, if available.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#conversation_select__fields
     *
     * @param bool $defaultToCurrent
     * @return $this
     */
    public function defaultToCurrent(bool $defaultToCurrent = true): self
    {
        $this->defaultToCurrent = $defaultToCurrent;
        return $this;
    }

    /**
     * This field only works with menus in input blocks in modals.
     * When set to true, the view_submission payload from the menu's parent view will contain a response_url.
     * This response_url can be used for message responses. The target conversation for the message will be
     * determined by the value of this select menu.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#conversation_select__fields
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
        return static::TYPE_SELECT_MENU_CONVERSATIONS;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption($this->mergeFilter([
            'default_to_current_conversation' => $this->defaultToCurrent,
            'response_url_enabled' => $this->responseUrlEnabled,
        ])));
    }
}
