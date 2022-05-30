<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Nwilging\LaravelSlackBot\Support\SlackCommandRequest;
use Symfony\Component\HttpFoundation\Response;

interface SlackCommandHandlerContract
{
    public function handle(SlackCommandRequest $commandRequest): Response;
}
