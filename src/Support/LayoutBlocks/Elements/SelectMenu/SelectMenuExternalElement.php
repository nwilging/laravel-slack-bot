<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Select Menu External Options Element
 * @see https://api.slack.com/reference/block-kit/block-elements#external_select
 */
class SelectMenuExternalElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    protected ?int $minQueryLength = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    /**
     * When the typeahead field is used, a request will be sent on every character change.
     * If you prefer fewer requests or more fully ideated queries, use the withMinQueryLength attribute to tell Slack
     * the fewest number of typed characters required before dispatch. The default value is 3.
     *
     * @see https://api.slack.com/reference/block-kit/block-elements#external_select__fields
     *
     * @param int $length
     * @return $this
     */
    public function withMinQueryLength(int $length): self
    {
        $this->minQueryLength = $length;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_SELECT_MENU_EXTERNAL;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption([
            'min_query_length' => $this->minQueryLength,
        ]));
    }
}
