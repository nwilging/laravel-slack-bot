<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Mockery\MockInterface;
use Nwilging\LaravelSlackBot\Contracts\Services\SlackCommandHandlerFactoryServiceContract;
use Nwilging\LaravelSlackBot\Contracts\SlackCommandHandlerContract;
use Nwilging\LaravelSlackBot\Services\SlackCommandHandlerService;
use Nwilging\LaravelSlackBot\Support\SlackCommandRequest;
use Nwilging\LaravelSlackBotTests\TestCase;

class SlackCommandHandlerServiceTest extends TestCase
{
    /**
     * Generated with:
     * `openssl rand -hex 16`
     *
     * Not a real slack signing key.
     */
    protected string $testSigningKey = '11f1ae1af09ccb257214ba904873c789';

    protected MockInterface $slackCommandHandlerFactory;

    protected SlackCommandHandlerService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->slackCommandHandlerFactory = \Mockery::mock(SlackCommandHandlerFactoryServiceContract::class);
        $this->service = new SlackCommandHandlerService($this->slackCommandHandlerFactory, $this->testSigningKey);
    }

    public function testHandleThrowsExceptionWhenRequiredHeaderTimestampMissing()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('header')->with('X-Slack-Request-Timestamp')->andReturnNull();
        $request->shouldReceive('header')->with('X-Slack-Signature')->andReturnNull();
        $request->shouldReceive('isJson')->andReturnFalse();
        $request->shouldReceive('toArray')->andReturn([]);

        $this->expectException(UnauthorizedException::class);
        $this->service->handle($request);
    }

    public function testHandleThrowsExceptionWhenRequiredHeaderSignatureMissing()
    {
        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('header')->with('X-Slack-Request-Timestamp')->andReturn('12345');
        $request->shouldReceive('header')->with('X-Slack-Signature')->andReturnNull();
        $request->shouldReceive('isJson')->andReturnFalse();
        $request->shouldReceive('toArray')->andReturn([]);

        $this->expectException(UnauthorizedException::class);
        $this->service->handle($request);
    }

    public function testHandleThrowsExceptionWhenSignaturesDoNotMatch()
    {
        /**
         * Generated with:
         * `openssl rand -hex 16`
         *
         * Not a real slack signing key.
         */
        $invalidSigningKey = 'd23375f4085b76a94f6df746fbcd62ef';
        $requestData = [
            'key' => 'value',
            'key2' => 'val2',
        ];

        $formattedRequestBody = implode('&', array_map(function (string $key) use ($requestData): string {
            return sprintf('%s=%s', urlencode($key), urlencode($requestData[$key] ?? ''));
        }, array_keys($requestData)));

        $headerTimestamp = '12345';

        $headerSignatureBase = sprintf('v0:%s:%s', $headerTimestamp, $formattedRequestBody);
        $headerSignature = sprintf('v0=%s', hash_hmac('sha256', $headerSignatureBase, $invalidSigningKey));

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('header')->with('X-Slack-Request-Timestamp')->andReturn($headerTimestamp);
        $request->shouldReceive('header')->with('X-Slack-Signature')->andReturn($headerSignature);
        $request->shouldReceive('isJson')->andReturnFalse();
        $request->shouldReceive('toArray')->andReturn($requestData);

        $this->expectException(UnauthorizedException::class);
        $this->service->handle($request);
    }

    public function testHandleSuccess()
    {
        $requestData = [
            'token' => 'test-token',
            'team_id' => 'test-team-id',
            'team_domain' => 'test-team-domain',
            'channel_id' => 'test-channel-id',
            'channel_name' => 'test-channel-name',
            'user_id' => 'test-user-id',
            'user_name' => 'test-user-name',
            'command' => '/test-command',
            'text' => 'arg1 arg2 arg3',
            'api_app_id' => 'test-api-app-id',
            'is_enterprise_install' => 'true',
            'response_url' => 'test-response-url',
            'trigger_id' => 'test-trigger-id',
        ];

        $formattedRequestBody = implode('&', array_map(function (string $key) use ($requestData): string {
            return sprintf('%s=%s', urlencode($key), urlencode($requestData[$key] ?? ''));
        }, array_keys($requestData)));

        $headerTimestamp = '12345';

        $headerSignatureBase = sprintf('v0:%s:%s', $headerTimestamp, $formattedRequestBody);
        $headerSignature = sprintf('v0=%s', hash_hmac('sha256', $headerSignatureBase, $this->testSigningKey));

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('header')->with('X-Slack-Request-Timestamp')->andReturn($headerTimestamp);
        $request->shouldReceive('header')->with('X-Slack-Signature')->andReturn($headerSignature);
        $request->shouldReceive('isJson')->andReturnTrue();
        $request->shouldReceive('json')->andReturnSelf();

        $request->shouldAllowMockingMethod('all');
        $request->shouldReceive('all')->andReturn($requestData);

        $responseMock = \Mockery::mock(Response::class);

        $handlerMock = \Mockery::mock(SlackCommandHandlerContract::class);
        $handlerMock->shouldReceive('handle')
            ->once()
            ->with(\Mockery::on(function (SlackCommandRequest $slackRequest) use ($requestData): bool {
                $this->assertSame($slackRequest->token, $requestData['token']);
                $this->assertSame($slackRequest->teamId, $requestData['team_id']);
                $this->assertSame($slackRequest->teamDomain, $requestData['team_domain']);
                $this->assertSame($slackRequest->channelId, $requestData['channel_id']);
                $this->assertSame($slackRequest->channelName, $requestData['channel_name']);
                $this->assertSame($slackRequest->userId, $requestData['user_id']);
                $this->assertSame($slackRequest->username, $requestData['user_name']);
                $this->assertSame($slackRequest->command, 'test-command');
                $this->assertSame($slackRequest->commandArgs, ['arg1', 'arg2', 'arg3']);
                $this->assertSame($slackRequest->apiAppId, $requestData['api_app_id']);
                $this->assertSame($slackRequest->isEnterpriseInstall, true);
                $this->assertSame($slackRequest->responseUrl, $requestData['response_url']);
                $this->assertSame($slackRequest->triggerId, $requestData['trigger_id']);

                return true;
            }))->andReturn($responseMock);

        $this->slackCommandHandlerFactory->shouldReceive('getHandler')
            ->once()
            ->with('test-command')
            ->andReturn($handlerMock);

        $result = $this->service->handle($request);
        $this->assertSame($responseMock, $result);
    }

    public function testHandleSuccessWithEmptyArgs()
    {
        $requestData = [
            'token' => 'test-token',
            'team_id' => 'test-team-id',
            'team_domain' => 'test-team-domain',
            'channel_id' => 'test-channel-id',
            'channel_name' => 'test-channel-name',
            'user_id' => 'test-user-id',
            'user_name' => 'test-user-name',
            'command' => '/test-command',
            'text' => null,
            'api_app_id' => 'test-api-app-id',
            'is_enterprise_install' => 'true',
            'response_url' => 'test-response-url',
            'trigger_id' => 'test-trigger-id',
        ];

        $formattedRequestBody = implode('&', array_map(function (string $key) use ($requestData): string {
            return sprintf('%s=%s', urlencode($key), urlencode($requestData[$key] ?? ''));
        }, array_keys($requestData)));

        $headerTimestamp = '12345';

        $headerSignatureBase = sprintf('v0:%s:%s', $headerTimestamp, $formattedRequestBody);
        $headerSignature = sprintf('v0=%s', hash_hmac('sha256', $headerSignatureBase, $this->testSigningKey));

        $request = \Mockery::mock(Request::class);
        $request->shouldReceive('header')->with('X-Slack-Request-Timestamp')->andReturn($headerTimestamp);
        $request->shouldReceive('header')->with('X-Slack-Signature')->andReturn($headerSignature);
        $request->shouldReceive('isJson')->andReturnTrue();
        $request->shouldReceive('json')->andReturnSelf();

        $request->shouldAllowMockingMethod('all');
        $request->shouldReceive('all')->andReturn($requestData);

        $responseMock = \Mockery::mock(Response::class);

        $handlerMock = \Mockery::mock(SlackCommandHandlerContract::class);
        $handlerMock->shouldReceive('handle')
            ->once()
            ->with(\Mockery::on(function (SlackCommandRequest $slackRequest) use ($requestData): bool {
                $this->assertSame($slackRequest->token, $requestData['token']);
                $this->assertSame($slackRequest->teamId, $requestData['team_id']);
                $this->assertSame($slackRequest->teamDomain, $requestData['team_domain']);
                $this->assertSame($slackRequest->channelId, $requestData['channel_id']);
                $this->assertSame($slackRequest->channelName, $requestData['channel_name']);
                $this->assertSame($slackRequest->userId, $requestData['user_id']);
                $this->assertSame($slackRequest->username, $requestData['user_name']);
                $this->assertSame($slackRequest->command, 'test-command');
                $this->assertSame($slackRequest->commandArgs, ['']);
                $this->assertSame($slackRequest->apiAppId, $requestData['api_app_id']);
                $this->assertSame($slackRequest->isEnterpriseInstall, true);
                $this->assertSame($slackRequest->responseUrl, $requestData['response_url']);
                $this->assertSame($slackRequest->triggerId, $requestData['trigger_id']);

                return true;
            }))->andReturn($responseMock);

        $this->slackCommandHandlerFactory->shouldReceive('getHandler')
            ->once()
            ->with('test-command')
            ->andReturn($handlerMock);

        $result = $this->service->handle($request);
        $this->assertSame($responseMock, $result);
    }
}
