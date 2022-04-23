<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class FilterObject extends CompositionObject
{
    use MergesArrays;

    /**
     * @var string[]|null
     */
    protected ?array $include = null;

    protected ?bool $excludeExternalSharedChannels = null;

    protected ?bool $excludeBotUsers = null;

    public function includeConversationTypes(array $include = []): self
    {
        $this->include = $include;
        return $this;
    }

    public function excludeExternalSharedChannels(bool $exclude = true): self
    {
        $this->excludeExternalSharedChannels = $exclude;
        return $this;
    }

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
