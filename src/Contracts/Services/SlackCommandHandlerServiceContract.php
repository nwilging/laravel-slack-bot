<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Services;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface SlackCommandHandlerServiceContract
{
    public function handle(Request $request): Response;
}
