<?php
declare(strict_types=1);

namespace Tests\Unit\Support\LayoutBuilder;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\ActionsBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\ContextBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\DividerBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\HeaderBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\MarkdownObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBuilder\Builder;
use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    public function testWithPlainText()
    {
        $text = 'test text';

        $builder = new Builder();
        $result = $builder->withPlainText($text);

        $this->assertInstanceOf(TextObject::class, $result);
        $this->assertEquals([
            'type' => 'plain_text',
            'text' => $text,
        ], $result->toArray());
    }

    public function testWithMarkdownText()
    {
        $text = 'test text';

        $builder = new Builder();
        $result = $builder->withMarkdownText($text);

        $this->assertInstanceOf(MarkdownObject::class, $result);
        $this->assertEquals([
            'type' => 'mrkdwn',
            'text' => $text,
        ], $result->toArray());
    }

    public function testDivider()
    {
        $builder = new Builder();
        $builder->divider();

        $blocks = $builder->getBlocks();
        $this->assertCount(1, $blocks);
        $this->assertInstanceOf(DividerBlock::class, $blocks[0]);
    }

    public function testHeader()
    {
        $text = 'test header';

        $builder = new Builder();
        $builder->header($text);

        $blocks = $builder->getBlocks();
        $this->assertCount(1, $blocks);
        $this->assertInstanceOf(HeaderBlock::class, $blocks[0]);
        $this->assertEquals([
            'type' => 'header',
            'text' => [
                'type' => 'plain_text',
                'text' => $text,
            ],
        ], $blocks[0]->toArray());
    }

    public function testAddBlock()
    {
        $block1 = new ActionsBlock([]);
        $block2 = new DividerBlock();
        $block3 = new ContextBlock([], []);

        $builder = new Builder();

        $builder
            ->addBlock($block3)
            ->addBlock($block1)
            ->addBlock($block2);

        $blocks = $builder->getBlocks();
        $this->assertCount(3, $blocks);

        $first = $blocks[0];
        $second = $blocks[1];
        $third = $blocks[2];

        $this->assertSame($block3, $first);
        $this->assertSame($block1, $second);
        $this->assertSame($block2, $third);
    }
}
