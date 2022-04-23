<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Section Block
 * @see https://api.slack.com/reference/block-kit/blocks#section
 */
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

    /**
     * Preferred. The text for the block. Maximum length for the text in this field is 3000 characters.
     * This field is not required if a valid array of fields objects is provided instead.
     *
     * @see https://api.slack.com/reference/block-kit/blocks#section_fields
     *
     * @param TextObject $text
     * @return $this
     */
    public function withText(TextObject $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Required if no text is provided. An array of text objects.
     * Any text objects included with fields will be rendered in a compact format that allows for 2 columns of
     * side-by-side text. Maximum number of items is 10. Maximum length for the text in each item is 2000 characters.
     *
     * @see https://api.slack.com/reference/block-kit/blocks#section_fields
     *
     * @param TextObject[] $fields
     * @return $this
     */
    public function withFields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * A Block Element to add as an accessory to this section
     *
     * @see https://api.slack.com/reference/block-kit/blocks#section_fields
     *
     * @param Element $accessory
     * @return $this
     */
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
