<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithFilter;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Multi Select Conversations Element
 * @see https://api.slack.com/reference/block-kit/block-elements#conversation_multi_select
 */
class MultiSelectConversationElement extends MultiSelect
{
    use MergesArrays, WithFilter;

    protected ?array $initialConversations = null;

    protected ?bool $defaultToCurrent = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    /**
     * Pre-populates the select menu with the conversation that the user was viewing when they opened
     * the modal, if available.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#conversation_multi_select__fields
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
     * An array of one or more IDs of any valid conversations to be pre-selected when the menu loads.
     * If defaultToCurrent is also supplied, initial conversations will be ignored.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#conversation_multi_select__fields
     *
     * @param string[] $initialConversations
     * @return $this
     */
    public function withInitialConversations(array $initialConversations): self
    {
        $this->initialConversations = $initialConversations;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_MULTI_SELECT_CONVERSATIONS;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeFilter([
            'initial_conversations' => $this->initialConversations,
            'default_to_current_conversation' => $this->defaultToCurrent,
        ]));
    }
}
