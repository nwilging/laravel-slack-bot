<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Paginator implementation for Slack requests
 */
interface PaginatorContract extends Arrayable
{
    /**
     * Returns true if there are more pages
     *
     * @return bool
     */
    public function hasMorePages(): bool;

    /**
     * Returns the string cursor to retrieve the next page
     *
     * @return string|null
     */
    public function nextCursor(): ?string;
}
