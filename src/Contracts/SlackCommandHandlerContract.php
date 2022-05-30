<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Nwilging\LaravelSlackBot\Support\SlackCommandRequest;
use Symfony\Component\HttpFoundation\Response;

interface SlackCommandHandlerContract
{
    /**
     * Handle a slash command request and return an HTTP response to Slack. This method should
     * return an HTTP request as soon as possible so that Slack does not return a `timeout` response
     * to the user who issued the command.
     *
     * It is highly recommended to dispatch jobs from command handlers for any process that may take longer
     * than 500-1000 ms.
     *
     * @param SlackCommandRequest $commandRequest
     * @return Response
     */
    public function handle(SlackCommandRequest $commandRequest): Response;
}
