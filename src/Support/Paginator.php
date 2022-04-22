<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support;

use Nwilging\LaravelSlackBot\Contracts\PaginatorContract;

class Paginator implements PaginatorContract
{
    protected array $items = [];

    protected ?string $nextCursor = null;

    public function __construct(array $items, ?string $nextCursor = null)
    {
        $this->items = $items;
        $this->nextCursor = $nextCursor;
    }

    public function hasMorePages(): bool
    {
        return !is_null($this->nextCursor);
    }

    public function nextCursor(): ?string
    {
        return $this->nextCursor;
    }

    public function toArray(): array
    {
        return [
            'items' => $this->items,
            'next_cursor' => $this->nextCursor,
            'has_more_pages' => $this->hasMorePages(),
        ];
    }
}
