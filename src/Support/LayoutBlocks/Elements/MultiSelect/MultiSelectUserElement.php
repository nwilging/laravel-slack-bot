<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Multi Select Users Element
 * @see https://api.slack.com/reference/block-kit/block-elements#users_multi_select
 */
class MultiSelectUserElement extends MultiSelect
{
    use MergesArrays;

    protected ?array $initialUsers = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    /**
     * An array of user IDs of any valid users to be pre-selected when the menu loads.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#users_multi_select__fields
     *
     * @param string[] $initialUsers
     * @return $this
     */
    public function withInitialUsers(array $initialUsers): self
    {
        $this->initialUsers = $initialUsers;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_MULTI_SELECT_USERS;
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
            'initial_users' => $this->initialUsers,
        ]);
    }
}
