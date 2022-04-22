<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Illuminate\Contracts\Support\Arrayable;

interface PaginatorContract extends Arrayable
{
    public function hasMorePages(): bool;

    public function nextCursor(): ?string;
}
