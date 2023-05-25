<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Services;

use GuzzleHttp\ClientInterface;
use Nwilging\LaravelSlackBot\Contracts\PaginatorContract;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\Paginator;
use Nwilging\LaravelSlackBot\Contracts\SlackApiServiceContract;
use Psr\Http\Message\ResponseInterface;

class SlackApiService implements SlackApiServiceContract
{
    protected ClientInterface $httpClient;

    protected string $botToken;

    protected string $apiUrl;

    public function __construct(ClientInterface $httpClient, string $botToken, string $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->botToken = $botToken;
        $this->apiUrl = $apiUrl;
    }

    public function listConversations(
        int $limit = 100,
        ?string $cursor = null,
        bool $excludeArchived = false,
        ?string $teamId = null,
        bool $includePrivate = true
    ): PaginatorContract
    {
        $args = [
            'types' => 'public_channel' . (($includePrivate) ? ',private_channel' : null),
            'limit' => $limit,
            'exclude_archived' => $excludeArchived ? 'true' : 'false',
        ];

        if ($cursor) $args['cursor'] = $cursor;
        if ($teamId) $args['team_id'] = $teamId;

        $response = $this->makeRequest('GET', 'conversations.list', [], $args);
        $result = json_decode($response->getBody()->getContents(), true);

        $channels = $result['channels'];
        $nextCursor = (!empty($result['response_metadata']) && !empty($result['response_metadata']['next_cursor']))
            ? $result['response_metadata']['next_cursor']
            : null;

        return new Paginator($channels, $nextCursor);
    }

    public function getChannelByName(string $channelName): ?array
    {
        $nextCursor = null;
        do {
            $paginator = $this->listConversations(1000, $nextCursor);
            foreach ($paginator->toArray()['items'] as $channel) {
                if ($channel['name'] === $channelName) {
                    return $channel;
                }
            }

            $nextCursor = $paginator->nextCursor();
        } while ($paginator->hasMorePages());

        return null;
    }

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
    public function sendTextMessage(string $channelId, string $message, array $options = []): void
    {
        $payload = array_merge([
            'channel' => $channelId,
            'text' => $message,
        ], $this->buildMessageOptions($options));

        $response = $this->makeRequest('POST', 'chat.postMessage', $payload);
    }

    /**
     * @param string $channelId
     * @param Block[] $blocks
     * @param array $options
     * @return void
     */
    public function sendBlocksMessage(string $channelId, array $blocks, array $options = []): void
    {
        $blocksArray = array_map(function (Block $block): array {
            return $block->toArray();
        }, $blocks);

        $payload = array_merge([
            'channel' => $channelId,
            'blocks' => $blocksArray,
        ], $this->buildMessageOptions($options));

        $response = $this->makeRequest('POST', 'chat.postMessage', $payload);
    }

    protected function buildMessageOptions(array $options): array
    {
        $payload = [];
        if (!empty($options['username'])) {
            $payload['username'] = $options['username'];
        }

        if (!empty($options['icon'])) {
            if (!empty($options['icon']['emoji'])) {
                $payload['icon_emoji'] = $options['icon']['emoji'];
            } elseif (!empty($options['icon']['url'])) {
                $payload['icon_url'] = $options['icon']['url'];
            }
        }

        if (!empty($options['unfurl'])) {
            $unfurlOptions = $options['unfurl'];

            if (isset($unfurlOptions['media'])) $payload['unfurl_media'] = $unfurlOptions['media'];
            if (isset($unfurlOptions['links'])) $payload['unfurl_links'] = $unfurlOptions['links'];
        }

        if (!empty($options['thread'])) {
            $threadOptions = $options['thread'];

            if (!empty($threadOptions['ts'])) $payload['thread_ts'] = $threadOptions['ts'];
            if (!empty($threadOptions['send_to_channel'])) $payload['reply_broadcast'] = $threadOptions['send_to_channel'];
        }

        if (!empty($options['markdown'])) $payload['mrkdwn'] = $options['markdown'];
        if (!empty($options['parse'])) $payload['parse'] = $options['parse'];
        if (!empty($options['metadata'])) $payload['metadata'] = $options['metadata'];

        return $payload;
    }

    protected function makeRequest(string $method, string $endpoint, array $payload = [], array $queryString = []): ResponseInterface
    {
        $url = sprintf('%s/%s', $this->apiUrl, $endpoint);
        if (!empty($queryString)) {
            $formattedQueryStrings = [];
            foreach ($queryString as $key => $value) {
                $formattedQueryStrings[] = sprintf('%s=%s', urlencode((string) $key), urlencode((string) $value));
            }

            $url .= sprintf('?%s', implode('&', $formattedQueryStrings));
        }

        $options = [
            'headers' => [
                'Authorization' => sprintf('Bearer %s', $this->botToken),
                'Content-Type' => 'application/json;charset=utf8',
            ],
            'json' => $payload,
        ];

        return $this->httpClient->request($method, $url, $options);
    }
}
