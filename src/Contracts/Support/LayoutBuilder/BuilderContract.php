<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Support\LayoutBuilder;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\MarkdownObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;

/**
 * Slack layout blocks message builder
 */
interface BuilderContract
{
    /**
     * Adds a layout block to the message
     *
     * @param Block $block
     * @return $this
     */
    public function addBlock(Block $block): self;

    /**
     * Adds a Header block to the message
     *
     * @param string $text
     * @return $this
     */
    public function header(string $text): self;

    /**
     * Adds a Divider block to the message
     *
     * @return $this
     */
    public function divider(): self;

    /**
     * Helper method to return a TextObject with the given $text
     *
     * @param string $text
     * @return TextObject
     */
    public function withPlainText(string $text): TextObject;

    /**
     * Helper method to return a MarkdownObject with the given $text
     *
     * @param string $text
     * @return MarkdownObject
     */
    public function withMarkdownText(string $text): MarkdownObject;
}
