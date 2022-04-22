<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Support\LayoutBuilder;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\MarkdownObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;

interface BuilderContract
{
    public function addBlock(Block $block): self;

    public function header(string $text): self;

    public function divider(): self;

    public function withPlainText(string $text): TextObject;

    public function withMarkdownText(string $text): MarkdownObject;
}
