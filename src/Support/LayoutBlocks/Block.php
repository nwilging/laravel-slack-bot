<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

abstract class Block implements Arrayable
{
    public const TYPE_ACTIONS = 'actions';
    public const TYPE_CONTEXT = 'context';
    public const TYPE_DIVIDER = 'divider';
    public const TYPE_FILE = 'file';
    public const TYPE_HEADER = 'header';
    public const TYPE_IMAGE = 'image';
    public const TYPE_INPUT = 'input';
    public const TYPE_SECTION = 'section';

    protected ?string $blockId = null;

    public function __construct(?string $blockId = null)
    {
        $this->blockId = $blockId;
    }

    public abstract function getType(): string;

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->getType(),
            'block_id' => $this->blockId,
        ]);
    }
}
