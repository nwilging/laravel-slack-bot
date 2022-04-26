<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * File Block
 * @see https://api.slack.com/reference/block-kit/blocks#file_fields
 */
class FileBlock extends Block
{
    use MergesArrays;

    protected string $externalId;

    public function __construct(string $externalId, ?string $blockId = null)
    {
        parent::__construct($blockId);
        $this->externalId = $externalId;
    }

    public function getType(): string
    {
        return static::TYPE_FILE;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'external_id' => $this->externalId,
            /**
             * At the moment, source will always be remote for a remote file.
             * @see https://api.slack.com/reference/block-kit/blocks#file_fields
             */
            'source' => 'remote',
        ]);
    }
}
