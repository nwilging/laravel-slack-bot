<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Services;

use Nwilging\LaravelSlackBot\Contracts\SlackCommandHandlerContract;

interface SlackCommandHandlerFactoryServiceContract
{
    /**
     * Register a command handler class to a given command name
     *
     * @param string $slackCommandHandlerClass
     * @param string $slackSlashCommand
     * @return void
     */
    public function register(string $slackCommandHandlerClass, string $slackSlashCommand): void;

    /**
     * Attempt to retrieve a command handler class. Will throw an exception if the given
     * command does not have a registered handler.
     *
     * @param string $slackSlashCommand
     * @return SlackCommandHandlerContract
     */
    public function getHandler(string $slackSlashCommand): SlackCommandHandlerContract;
}
