<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;

interface SlackApiServiceContract
{
    public function listConversations(
        int $limit = 100,
        ?string $cursor = null,
        bool $excludeArchived = false,
        ?string $teamId = null,
        bool $includePrivate = true
    ): PaginatorContract;

    public function getChannelByName(string $channelName): ?array;

    /**
     * @param string $channelId
     * @param string $message
     * @param array{
     *      username?: string,
     *      icon?: {
     *          emoji?: string,
     *          url?: string,
     *      },
     *      unfurl?: {
     *          'media': bool,
     *          'links': bool,
     *      },
     *      thread?: {
     *          ts?: string,
     *          send_to_channel?: bool,
     *      },
     *      link_names?: bool,
     *      metadata?: array,
     *      parse?: string,
     *      markdown?: bool,
     * } $options
     * @return void
     */
    public function sendTextMessage(string $channelId, string $message, array $options = []): void;

    /**
     * @param string $channelId
     * @param Block[] $blocks
     * @param array $options
     * @return void
     */
    public function sendBlocksMessage(string $channelId, array $blocks, array $options = []): void;
}
