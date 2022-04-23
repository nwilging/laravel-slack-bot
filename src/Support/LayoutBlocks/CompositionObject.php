<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

abstract class CompositionObject implements Arrayable
{
    /**
     * The Slack-API compatible array for this composition object
     *
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
