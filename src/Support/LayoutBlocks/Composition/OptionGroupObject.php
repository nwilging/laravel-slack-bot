<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class OptionGroupObject extends CompositionObject
{
    use MergesArrays;

    protected TextObject $label;

    /**
     * @var OptionObject[]
     */
    protected array $options;

    /**
     * @param TextObject $label
     * @param OptionObject[] $options
     */
    public function __construct(TextObject $label, array $options)
    {
        $this->label = $label;
        $this->options = $options;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'label' => $this->label->toArray(),
            'options' => array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->options),
        ]);
    }
}
