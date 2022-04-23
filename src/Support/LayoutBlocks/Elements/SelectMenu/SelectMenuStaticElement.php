<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\HasInitialOption;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class SelectMenuStaticElement extends SelectMenu
{
    use MergesArrays, HasInitialOption;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    /**
     * @param string $actionId
     * @param TextObject $placeholder
     * @param OptionObject[] $options
     */
    public function __construct(string $actionId, TextObject $placeholder, array $options)
    {
        parent::__construct($actionId, $placeholder);
        $this->options = $options;
    }

    public function getType(): string
    {
        return static::TYPE_SELECT_MENU_STATIC;
    }

    public function toArray(): array
    {
        return $this->toMergedArray($this->mergeInitialOption([
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
        ]));
    }
}
