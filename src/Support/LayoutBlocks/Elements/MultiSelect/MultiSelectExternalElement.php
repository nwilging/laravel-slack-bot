<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class MultiSelectExternalElement extends MultiSelect
{
    use MergesArrays;

    protected ?int $minQueryLength = null;

    protected ?array $initialOptions = null;

    public function __construct(string $actionId, TextObject $placeholder)
    {
        parent::__construct($actionId, $placeholder);
    }

    public function withMinQueryLength(int $minQueryLength): self
    {
        $this->minQueryLength = $minQueryLength;
        return $this;
    }

    /**
     * @param OptionObject[] $options
     * @return $this
     */
    public function withInitialOptions(array $options): self
    {
        $this->initialOptions = $options;
        return $this;
    }

    public function getType(): string
    {
        return Element::TYPE_MULTI_SELECT_EXTERNAL;
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
            'min_query_length' => $this->minQueryLength,
            'initial_options' => ($this->initialOptions) ? array_map(function (OptionObject $option): array {
                return $option->toArray();
            }, $this->initialOptions) : null,
        ]);
    }
}
