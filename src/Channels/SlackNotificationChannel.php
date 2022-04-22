<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Channels;

use Illuminate\Notifications\Notification;
use Nwilging\LaravelSlackBot\Contracts\Channels\SlackNotificationChannelContract;
use Nwilging\LaravelSlackBot\Contracts\SlackApiServiceContract;

class SlackNotificationChannel implements SlackNotificationChannelContract
{
    protected SlackApiServiceContract $slackApiService;

    public function __construct(SlackApiServiceContract $slackApiService)
    {
        $this->slackApiService = $slackApiService;
    }

    public function send($notifiable, Notification $notification): void
    {
        $slackNotificationArray = $notification->toSlack();
        switch ($slackNotificationArray['contentType']) {
            case 'text':
                $this->handleTextMessage($slackNotificationArray);
                break;
            case 'blocks':
                $this->handleBlocksMessage($slackNotificationArray);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('%s is not a valid content type. Use `blocks` or `text`'));
        }
    }

    protected function handleBlocksMessage(array $slackNotificationArray): void
    {
        $blocks = $slackNotificationArray['blocks'];
        $options = $slackNotificationArray['options'] ?? [];

        $this->slackApiService->sendBlocksMessage($slackNotificationArray['channelId'], $blocks, $options);
    }

    protected function handleTextMessage(array $slackNotificationArray): void
    {
        $message = $slackNotificationArray['message'];
        $options = $slackNotificationArray['options'] ?? [];

        $this->slackApiService->sendTextMessage($slackNotificationArray['channelId'], $message, $options);
    }
}
