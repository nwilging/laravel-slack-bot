<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Channels;

use Illuminate\Notifications\Notification;
use Mockery\MockInterface;
use Nwilging\LaravelSlackBot\Channels\SlackNotificationChannel;
use Nwilging\LaravelSlackBot\Contracts\Notifications\SlackApiNotificationContract;
use Nwilging\LaravelSlackBot\Contracts\SlackApiServiceContract;
use Nwilging\LaravelSlackBotTests\TestCase;

class SlackNotificationChannelTest extends TestCase
{
    protected MockInterface $slackApiService;

    protected SlackNotificationChannel $channel;

    public function setUp(): void
    {
        parent::setUp();

        $this->slackApiService = \Mockery::mock(SlackApiServiceContract::class);
        $this->channel = new SlackNotificationChannel($this->slackApiService);
    }

    public function testSendThrowsInvalidArgumentException()
    {
        $notifiable = \Mockery::mock(\stdClass::class);
        $notification = new class extends Notification implements SlackApiNotificationContract {
            public function toSlackArray(): array
            {
                return [
                    'contentType' => 'invalid-type',
                ];
            }
        };

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('invalid-type is not a valid content type. Use `blocks` or `text`');

        $this->channel->send($notifiable, $notification);
    }

    public function testSendSendsTextMessage()
    {
        $notifiable = \Mockery::mock(\stdClass::class);
        $notification = new class extends Notification implements SlackApiNotificationContract{
            public function toSlackArray(): array
            {
                return [
                    'channelId' => 'C12345',
                    'contentType' => 'text',
                    'message' => 'test message',
                    'options' => [
                        'key' => 'value',
                    ],
                ];
            }
        };

        $this->slackApiService->shouldReceive('sendTextMessage')
            ->once()
            ->with('C12345', 'test message', ['key' => 'value']);

        $this->channel->send($notifiable, $notification);
    }

    public function testSendTextMessageSendsEmptyOptionsArray()
    {
        $notifiable = \Mockery::mock(\stdClass::class);
        $notification = new class extends Notification implements SlackApiNotificationContract{
            public function toSlackArray(): array
            {
                return [
                    'channelId' => 'C12345',
                    'contentType' => 'text',
                    'message' => 'test message',
                ];
            }
        };

        $this->slackApiService->shouldReceive('sendTextMessage')
            ->once()
            ->with('C12345', 'test message', []);

        $this->channel->send($notifiable, $notification);
    }

    public function testSendBlocksMessage()
    {
        $notifiable = \Mockery::mock(\stdClass::class);
        $notification = new class extends Notification implements SlackApiNotificationContract{
            public function toSlackArray(): array
            {
                return [
                    'channelId' => 'C12345',
                    'contentType' => 'blocks',
                    'blocks' => [1, 2, 3],
                    'options' => ['key' => 'value'],
                ];
            }
        };

        $expectedBlocks = [1, 2, 3];

        $this->slackApiService->shouldReceive('sendBlocksMessage')
            ->once()
            ->with('C12345', $expectedBlocks, ['key' => 'value']);

        $this->channel->send($notifiable, $notification);
    }

    public function testSendBlocksMessageSendsEmptyOptionsArray()
    {
        $notifiable = \Mockery::mock(\stdClass::class);
        $notification = new class extends Notification implements SlackApiNotificationContract {
            public function toSlackArray(): array
            {
                return [
                    'channelId' => 'C12345',
                    'contentType' => 'blocks',
                    'blocks' => [1, 2, 3],
                ];
            }
        };

        $expectedBlocks = [1, 2, 3];

        $this->slackApiService->shouldReceive('sendBlocksMessage')
            ->once()
            ->with('C12345', $expectedBlocks, []);

        $this->channel->send($notifiable, $notification);
    }
}
