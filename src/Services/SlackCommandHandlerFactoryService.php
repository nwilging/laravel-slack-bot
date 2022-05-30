<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Services;

use Illuminate\Contracts\Foundation\Application;
use Nwilging\LaravelSlackBot\Contracts\Services\SlackCommandHandlerFactoryServiceContract;
use Nwilging\LaravelSlackBot\Contracts\SlackCommandHandlerContract;

class SlackCommandHandlerFactoryService implements SlackCommandHandlerFactoryServiceContract
{
    protected Application $laravel;

    protected array $commandHandlers = [];

    public function __construct(Application $laravel)
    {
        $this->laravel = $laravel;
    }

    public function register(string $slackCommandHandlerClass, string $slackSlashCommand): void
    {
        $this->commandHandlers[$slackSlashCommand] = $slackCommandHandlerClass;
    }

    public function getHandler(string $slackSlashCommand): SlackCommandHandlerContract
    {
        if (!array_key_exists($slackSlashCommand, $this->commandHandlers)) {
            throw new \InvalidArgumentException(sprintf('No handler found for command %s', $slackSlashCommand));
        }

        return $this->laravel->make($this->commandHandlers[$slackSlashCommand]);
    }
}
