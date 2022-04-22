<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Channels;

use Illuminate\Notifications\Notification;

interface SlackNotificationChannelContract
{
    public function send($notifiable, Notification $notification): void;
}
