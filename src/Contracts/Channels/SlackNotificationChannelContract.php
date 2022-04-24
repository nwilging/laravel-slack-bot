<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Channels;

use Illuminate\Notifications\Notifiable;
use Nwilging\LaravelSlackBot\Contracts\Notifications\SlackApiNotificationContract;

interface SlackNotificationChannelContract
{
    /**
     * Send a notification via the Slack API. The `$notification` should be an implementation of
     * the SlackApiNotificationContract.
     *
     * @param Notifiable $notifiable
     * @param SlackApiNotificationContract $notification
     * @return void
     */
    public function send($notifiable, SlackApiNotificationContract $notification): void;
}
