<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\FileBlock;
use Nwilging\LaravelSlackBotTests\TestCase;

class FileBlockTest extends TestCase
{
    public function testBlock()
    {
        $externalId = 'external-id';
        $blockId = 'block-id';

        $block = new FileBlock($externalId, $blockId);

        $this->assertEquals([
            'type' => Block::TYPE_FILE,
            'external_id' => $externalId,
            'block_id' => $blockId,
            'source' => 'remote',
        ], $block->toArray());
    }
}
