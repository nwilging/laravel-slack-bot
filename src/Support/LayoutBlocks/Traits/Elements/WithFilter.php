<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\FilterObject;

trait WithFilter
{
    protected ?FilterObject $filter = null;

    /**
     * A filter object that reduces the list of available conversations/channels using the specified criteria.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#filter_conversations
     *
     * @param FilterObject $filter
     * @return $this
     */
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
