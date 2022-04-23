<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\FilterObject;

trait WithFilter
{
    protected ?FilterObject $filter = null;

    public function withFilter(FilterObject $filter): self
    {
        $this->filter = $filter;
        return $this;
    }

    protected function mergeFilter(array $mergeWith): array
    {
        return array_filter(array_merge($mergeWith, [
            'filter' => ($this->filter) ? $this->filter->toArray() : null,
        ]));
    }
}
