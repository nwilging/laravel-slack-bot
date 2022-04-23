<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Filter Object for Conversations
 * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations
 */
class FilterObject extends CompositionObject
{
    use MergesArrays;

    /**
     * @var string[]|null
     */
    protected ?array $include = null;

    protected ?bool $excludeExternalSharedChannels = null;

    protected ?bool $excludeBotUsers = null;

    /**
     * Indicates which type of conversations should be included in the list.
     * When this field is provided, any conversations that do not match will be excluded You should provide an array
     * of strings from the following options: `im`, `mpim`, `private`, and `public`. The array cannot be empty.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations__fields
     *
     * @param array $include
     * @return $this
     */
    public function includeConversationTypes(array $include = []): self
    {
        $this->include = $include;
        return $this;
    }

    /**
     * Indicates whether to exclude external shared channels from conversation lists.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations__fields
     *
     * @param bool $exclude
     * @return $this
     */
    public function excludeExternalSharedChannels(bool $exclude = true): self
    {
        $this->excludeExternalSharedChannels = $exclude;
        return $this;
    }

    /**
     * Indicates whether to exclude bot users from conversation lists.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations__fields
     *
     * @param bool $exclude
     * @return $this
     */
    public function excludeBotUsers(bool $exclude = true): self
    {
        $this->excludeBotUsers = $exclude;
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'include' => $this->include,
            'exclude_external_shared_channels' => $this->excludeExternalSharedChannels,
            'exclude_bot_users' => $this->excludeBotUsers,
        ]);
    }
}
