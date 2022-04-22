<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\HasActionId;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class ButtonElement extends Element
{
    use HasActionId, MergesArrays;

    protected TextObject $text;

    protected ?string $style = null;

    protected ?string $url = null;

    protected ?string $value = null;

    protected ?string $accessibilityLabel = null;

    public function __construct(TextObject $text, string $actionId)
    {
        $this->text = $text;
        $this->actionId = $actionId;
    }

    public function primary(): self
    {
        $this->style = 'primary';
        return $this;
    }

    public function danger(): self
    {
        $this->style = 'danger';
        return $this;
    }

    public function getType(): string
    {
        return static::TYPE_BUTTON;
    }

    public function withUrl(string $url, ?string $value = null): self
    {
        $this->url = $url;
        $this->value = $value;
        return $this;
    }

    public function withAccessibilityLabel(string $accessibilityLabel): self
    {
        $this->accessibilityLabel = $accessibilityLabel;
        return $this;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_ACTIONS,
            Block::TYPE_SECTION,
        ];
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'text' => $this->text->toArray(),
            'action_id' => $this->actionId,
            'style' => $this->style,
            'url' => $this->url,
            'value' => $this->value,
            'accessibility_label' => $this->accessibilityLabel,
        ]);
    }
}
