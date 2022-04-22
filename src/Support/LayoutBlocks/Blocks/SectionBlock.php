<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class SectionBlock extends Block
{
    use MergesArrays;

    protected ?TextObject $text = null;

    /**
     * @var TextObject[]|null
     */
    protected ?array $fields = null;

    protected ?Element $accessory = null;

    public function __construct(?string $blockId = null)
    {
        parent::__construct($blockId);
    }

    public function withText(TextObject $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @param TextObject[] $fields
     * @return $this
     */
    public function withFields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    public function withAccessory(Element $accessory): self
    {
        $this->accessory = $accessory;
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_SECTION;
    }

    public function toArray(): array
    {
        $data = [
            'accessory' => ($this->accessory) ? $this->accessory->toArray() : null,
        ];

        if (!$this->fields) {
            $data['text'] = $this->text->toArray();
        } else {
            $data['fields'] = array_map(function (TextObject $textObject): array {
                return $textObject->toArray();
            }, $this->fields);
        }

        return $this->toMergedArray($data);
    }
}
