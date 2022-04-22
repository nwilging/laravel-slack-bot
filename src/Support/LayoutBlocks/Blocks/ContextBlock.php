<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasElements;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class ContextBlock extends Block
{
    use HasElements, MergesArrays;

    /**
     * @var TextObject[]
     */
    protected array $textObjects;

    /**
     * @param TextObject[] $textObjects
     * @param Element[] $elements
     * @param string|null $blockId
     */
    public function __construct(array $textObjects, array $elements, ?string $blockId = null)
    {
        parent::__construct($blockId);

        $this->textObjects = $textObjects;
        $this->elements = $elements;
    }

    public function getType(): string
    {
        return static::TYPE_CONTEXT;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'elements' => array_merge($this->elementsArray(), array_map(function (TextObject $textObject): array {
                return $textObject->toArray();
            }, $this->textObjects)),
            'block_id' => $this->blockId,
        ]);
    }
}
