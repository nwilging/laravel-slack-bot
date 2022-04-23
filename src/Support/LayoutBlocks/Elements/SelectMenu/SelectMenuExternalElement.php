<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class SelectMenuExternalElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    protected ?int $minQueryLength = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

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
