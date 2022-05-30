<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Services;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface SlackCommandHandlerServiceContract
{
    /**
     * Handles a Slack Slash Command request. This method should be called from a controller.
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response;
}
