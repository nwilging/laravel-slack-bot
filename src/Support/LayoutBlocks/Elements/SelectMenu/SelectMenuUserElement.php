<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Select Menu Users Element
 * @see https://api.slack.com/reference/block-kit/block-elements#users_select
 */
class SelectMenuUserElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
        $this->initialOptionKeyName = 'initial_user';
    }

    public function getType(): string
    {
        return static::TYPE_SELECT_MENU_USERS;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption());
    }
}
