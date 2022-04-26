<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Contracts;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\PostMessageResponse;

/**
 * Slack API Service Connector
 */
interface SlackApiServiceContract
{
    /**
     * Retrieve a list of conversations: channels, groups
     *
     * @param int $limit - Number of items per page
     * @param string|null $cursor - Cursor string to retrieve specific page
     * @param bool $excludeArchived - Flag to exclude archived conversations
     * @param string|null $teamId - Team ID (required for multi-org apps)
     * @param bool $includePrivate - Flag to include private conversations
     * @return PaginatorContract
     */
    public function listConversations(
        int $limit = 100,
        ?string $cursor = null,
        bool $excludeArchived = false,
        ?string $teamId = null,
        bool $includePrivate = true
    ): PaginatorContract;

    /**
     * Retrieves channel information for a given channel name
     *
     * @param string $channelName - The name of the channel
     * @return array|null
     */
    public function getChannelByName(string $channelName): ?array;

    /**
     * Sends a basic plain-text message
     *
     * @see https://api.slack.com/methods/chat.postMessage#arg_text
     *
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
     * @return PostMessageResponse
     */
    public function sendTextMessage(string $channelId, string $message, array $options = []): PostMessageResponse;

    /**
     * Sends a rich-text layout blocks message
     *
     * @see https://api.slack.com/methods/chat.postMessage#arg_blocks
     *
     * @param string $channelId
     * @param Block[] $blocks
     * @param array $options
     * @return PostMessageResponse
     */
    public function sendBlocksMessage(string $channelId, array $blocks, array $options = []): PostMessageResponse;
}
