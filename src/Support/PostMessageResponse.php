<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support;

class PostMessageResponse
{
    public int $httpStatus;

    public bool $ok;

    public ?string $error = null;

    public ?string $channel = null;

    public ?string $ts = null;

    public ?array $message = null;
}
