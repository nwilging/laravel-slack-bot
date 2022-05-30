<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Services;

use Nwilging\LaravelSlackBot\Contracts\SlackCommandHandlerContract;

interface SlackCommandHandlerFactoryServiceContract
{
    public function register(string $slackCommandHandlerClass, string $slackSlashCommand): void;

    public function getHandler(string $slackSlashCommand): SlackCommandHandlerContract;
}
