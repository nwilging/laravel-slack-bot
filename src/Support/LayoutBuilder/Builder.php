<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBuilder;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Contracts\Support\LayoutBuilder\BuilderContract;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\DividerBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\HeaderBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\MarkdownObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;

class Builder implements BuilderContract
{
    /**
     * @var Block[]
     */
    protected array $blocks = [];

    public function addBlock(Block $block): self
    {
        $this->blocks[] = $block;
        return $this;
    }

    public function header(string $text): self
    {
        $this->blocks[] = new HeaderBlock($this->withPlainText($text));
        return $this;
    }

    public function divider(): self
    {
        $this->blocks[] = new DividerBlock();
        return $this;
    }

    public function withPlainText(string $text): TextObject
    {
        return new TextObject($text);
    }

    public function withMarkdownText(string $text): MarkdownObject
    {
        return new MarkdownObject($text);
    }

    /**
     * @return Block[]
     */
    public function getBlocks(): array
    {
        return $this->blocks;
    }
}
