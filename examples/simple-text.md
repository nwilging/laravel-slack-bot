# Simple Text Message

![Message Example](../.github/images/simple-text.png)

Code:
```phpt
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Nwilging\LaravelSlackBot\Contracts\Notifications\SlackApiNotificationContract;
use Nwilging\LaravelSlackBot\Support\SlackOptionsBuilder;

class TestNotification extends Notification implements SlackApiNotificationContract
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlackArray(): array
    {
        $options = new SlackOptionsBuilder();
        $options->username('My Bot')
            ->iconEmoji(':smile:');

        return [
            'contentType' => 'text',
            'message' => 'This is a test message!',
            'channelId' => 'general',
            'options' => $options->toArray(),
        ];
    }
}
```
