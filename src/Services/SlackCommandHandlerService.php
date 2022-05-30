<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Services;

use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Nwilging\LaravelSlackBot\Contracts\Services\SlackCommandHandlerFactoryServiceContract;
use Nwilging\LaravelSlackBot\Contracts\Services\SlackCommandHandlerServiceContract;
use Nwilging\LaravelSlackBot\Support\SlackCommandRequest;
use Symfony\Component\HttpFoundation\Response;

class SlackCommandHandlerService implements SlackCommandHandlerServiceContract
{
    protected SlackCommandHandlerFactoryServiceContract $handlerFactory;

    protected string $signingSecret;

    public function __construct(SlackCommandHandlerFactoryServiceContract $handlerFactory, string $signingSecret)
    {
        $this->handlerFactory = $handlerFactory;
        $this->signingSecret = $signingSecret;
    }

    public function handle(Request $request): Response
    {
        $data = ($request->isJson()) ? $request->json()->all() : $request->toArray();
        $this->validateSignature($request, $data);

        $command = $this->generateCommandRequest($data);

        $handler = $this->handlerFactory->getHandler($command->command);
        return $handler->handle($command);
    }

    protected function generateCommandRequest(array $data): SlackCommandRequest
    {
        $request = new SlackCommandRequest();

        $request->token = $data['token'];
        $request->teamId = $data['team_id'];
        $request->teamDomain = $data['team_domain'];
        $request->channelId = $data['channel_id'];
        $request->channelName = $data['channel_name'];
        $request->userId = $data['user_id'];
        $request->username = $data['user_name'];
        $request->command = ltrim($data['command'], '/');
        $request->commandArgs = explode(' ', $data['text'] ?? '');
        $request->apiAppId = $data['api_app_id'];
        $request->isEnterpriseInstall = ($data['is_enterprise_install'] === 'true');
        $request->responseUrl = $data['response_url'];
        $request->triggerId = $data['trigger_id'];

        return $request;
    }

    protected function validateSignature(Request $request, array $data): void
    {
        $timestamp = $request->header('X-Slack-Request-Timestamp');
        $slackSignature = $request->header('X-Slack-Signature');
        if (!$timestamp || !$slackSignature) {
            throw new UnauthorizedException();
        }

        $formattedRequestBody = implode('&', array_map(function (string $key) use ($data): string {
            return sprintf('%s=%s', urlencode($key), urlencode($data[$key] ?? ''));
        }, array_keys($data)));

        $signatureBase = sprintf('v0:%s:%s', $timestamp, $formattedRequestBody);
        $signature = sprintf('v0=%s', hash_hmac('sha256', $signatureBase, $this->signingSecret));

        if (!hash_equals($signature, $slackSignature)) {
            throw new UnauthorizedException();
        }
    }
}
