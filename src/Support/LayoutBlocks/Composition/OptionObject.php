<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Option Object
 * @see https://api.slack.com/reference/block-kit/composition-objects#option
 */
class OptionObject extends CompositionObject
{
    use MergesArrays;

    protected string $text;

    protected string $value;

    protected ?TextObject $description = null;

    protected ?string $url = null;

    public function __construct(string $text, string $value)
    {
        $this->text = $text;
        $this->value = $value;
    }

    /**
     * A plain_text only text object that defines a line of descriptive text shown below the text field beside the
     * radio button. Maximum length for the text object within this field is 75 characters.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#option__fields
     *
     * @param TextObject $textObject
     * @return $this
     */
    public function withDescription(TextObject $textObject): self
    {
        $this->description = $textObject;
        return $this;
    }

    /**
     * A URL to load in the user's browser when the option is clicked.
     * The url attribute is only available in overflow menus. Maximum length for this field is 3000 characters.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#option__fields
     *
     * @param string $url
     * @return $this
     */
    public function withUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'text' => $this->text,
            'value' => $this->value,
            'description' => ($this->description) ? $this->description->toArray() : null,
            'url' => $this->url,
        ]);
    }
}
