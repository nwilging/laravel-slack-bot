<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts\Notifications;

interface SlackApiNotificationContract
{
    /**
     * Returns a Slack-API compliant notification array.
     *
     * @param mixed $notifiable
     * @return array{
     *      contentType: 'text'|'blocks',
     *      channelId: string,
     *      text?: string,
     *      blocks?: Block[],
     *      options?: array,
     * }
     */
    public function toSlackArray($notifiable): array;
}
