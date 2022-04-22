<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits;

trait MergesArrays
{
    protected function toMergedArray(array $toMerge): array
    {
        return array_filter(array_merge(parent::toArray(), $toMerge));
    }
}
