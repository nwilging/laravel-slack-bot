<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

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

    public function withDescription(TextObject $textObject): self
    {
        $this->description = $textObject;
        return $this;
    }

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
