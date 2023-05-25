<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Services;

use GuzzleHttp\ClientInterface;
use Nwilging\LaravelSlackBotTests\TestCase;
use Mockery\MockInterface;
use Nwilging\LaravelSlackBot\Services\SlackApiService;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\DividerBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks\HeaderBlock;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Psr\Http\Message\ResponseInterface;

class SlackApiServiceTest extends TestCase
{
    protected MockInterface $httpClient;

    protected string $botToken = 'test-token';

    protected string $apiUrl = 'https://example.com';

    protected SlackApiService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->httpClient = \Mockery::mock(ClientInterface::class);
        $this->service = new SlackApiService($this->httpClient, $this->botToken, $this->apiUrl);
    }

    public function testListConversations()
    {
        $expectedUrl = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=100&exclude_archived=false', $this->apiUrl);

        $expectedChannels = [
            [
                'id' => 'ABC123',
                'name' => 'test channel 1',
            ],
            [
                'id' => 'DEF456',
                'name' => 'test channel 2',
            ]
        ];
        $mockResponseContent = json_encode([
            'channels' => $expectedChannels,
        ]);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldAllowMockingMethod('getContents');

        $mockResponse->shouldReceive('getBody')->andReturnSelf();
        $mockResponse->shouldReceive('getContents')->andReturn($mockResponseContent);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse);

        $result = $this->service->listConversations();
        $this->assertEquals([
            'items' => $expectedChannels,
            'next_cursor' => null,
            'has_more_pages' => false,
        ], $result->toArray());
    }

    public function testListConversationsWithExtraOptions()
    {
        $expectedUrl = sprintf('%s/conversations.list?types=public_channel&limit=123&exclude_archived=true&team_id=abc123', $this->apiUrl);

        $expectedChannels = [
            [
                'id' => 'ABC123',
                'name' => 'test channel 1',
            ],
            [
                'id' => 'DEF456',
                'name' => 'test channel 2',
            ]
        ];
        $mockResponseContent = json_encode([
            'channels' => $expectedChannels,
        ]);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldAllowMockingMethod('getContents');

        $mockResponse->shouldReceive('getBody')->andReturnSelf();
        $mockResponse->shouldReceive('getContents')->andReturn($mockResponseContent);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse);

        $result = $this->service->listConversations(123, null, true, 'abc123', false);
        $this->assertEquals([
            'items' => $expectedChannels,
            'next_cursor' => null,
            'has_more_pages' => false,
        ], $result->toArray());
    }

    public function testListConversationsReturnsNextCursor()
    {
        $expectedUrl = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=100&exclude_archived=false', $this->apiUrl);

        $expectedNextCursor = 'abc123def456';
        $expectedChannels = [];

        $mockResponseContent = json_encode([
            'channels' => $expectedChannels,
            'response_metadata' => [
                'next_cursor' => $expectedNextCursor,
            ],
        ]);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldAllowMockingMethod('getContents');

        $mockResponse->shouldReceive('getBody')->andReturnSelf();
        $mockResponse->shouldReceive('getContents')->andReturn($mockResponseContent);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse);

        $result = $this->service->listConversations();
        $this->assertEquals([
            'items' => $expectedChannels,
            'next_cursor' => $expectedNextCursor,
            'has_more_pages' => true,
        ], $result->toArray());
    }

    public function testListConversationsSendsCursor()
    {
        $expectedUrl = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=100&exclude_archived=false&cursor=abc123def456', $this->apiUrl);

        $expectedChannels = [];
        $mockResponseContent = json_encode([
            'channels' => $expectedChannels,
        ]);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $mockResponse->shouldAllowMockingMethod('getContents');

        $mockResponse->shouldReceive('getBody')->andReturnSelf();
        $mockResponse->shouldReceive('getContents')->andReturn($mockResponseContent);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse);

        $result = $this->service->listConversations(100, 'abc123def456');
        $this->assertEquals([
            'items' => $expectedChannels,
            'next_cursor' => null,
            'has_more_pages' => false,
        ], $result->toArray());
    }

    public function testGetChannelByName()
    {
        $expectedUrl1 = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=1000&exclude_archived=false', $this->apiUrl);
        $expectedUrl2 = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=1000&exclude_archived=false&cursor=abc123def456', $this->apiUrl);

        $foundChannel = [
            'id' => 'A123',
            'name' => 'test channel!',
        ];

        $page1Channels = [
            [
                'name' => 'not the one',
            ],
            [
                'name' => 'still not the right channel',
            ],
        ];

        $page2Channels = [
            [
                'name' => 'almost there',
            ],
            $foundChannel,
            [
                'name' => 'this should not be reached',
            ]
        ];

        $mockResponse1Content = json_encode([
            'channels' => $page1Channels,
            'response_metadata' => [
                'next_cursor' => 'abc123def456',
            ],
        ]);

        $mockResponse2Content = json_encode([
            'channels' => $page2Channels,
        ]);

        $mockResponse1 = \Mockery::mock(ResponseInterface::class);
        $mockResponse2 = \Mockery::mock(ResponseInterface::class);

        $mockResponse1->shouldAllowMockingMethod('getContents');
        $mockResponse2->shouldAllowMockingMethod('getContents');

        $mockResponse1->shouldReceive('getBody')->andReturnSelf();
        $mockResponse1->shouldReceive('getContents')->andReturn($mockResponse1Content);

        $mockResponse2->shouldReceive('getBody')->andReturnSelf();
        $mockResponse2->shouldReceive('getContents')->andReturn($mockResponse2Content);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl1, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse1);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl2, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse2);

        $result = $this->service->getChannelByName('test channel!');
        $this->assertSame($foundChannel, $result);
    }

    public function testGetChannelByNameReturnsNull()
    {
        $expectedUrl1 = sprintf('%s/conversations.list?types=public_channel%%2Cprivate_channel&limit=1000&exclude_archived=false', $this->apiUrl);

        $page1Channels = [
            [
                'name' => 'not the one',
            ],
            [
                'name' => 'still not the right channel',
            ],
        ];

        $mockResponse1Content = json_encode([
            'channels' => $page1Channels,
        ]);

        $mockResponse1 = \Mockery::mock(ResponseInterface::class);
        $mockResponse1->shouldAllowMockingMethod('getContents');

        $mockResponse1->shouldReceive('getBody')->andReturnSelf();
        $mockResponse1->shouldReceive('getContents')->andReturn($mockResponse1Content);

        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('GET', $expectedUrl1, [
                'headers' => $this->expectedHeaders(),
                'json' => [],
            ])
            ->andReturn($mockResponse1);

        $result = $this->service->getChannelByName('test channel!');
        $this->assertNull($result);
    }

    /**
     * @dataProvider sendTextMessageOptionsDataProvider
     */
    public function testSendTextMessage(array $options, array $expectedOptions)
    {
        $channelId = 'C123456';
        $message = 'test message';

        $expectedPayload = array_merge([
            'channel' => $channelId,
            'text' => $message,
        ], $expectedOptions);

        $expectedUrl = sprintf('%s/chat.postMessage', $this->apiUrl);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('POST', $expectedUrl, \Mockery::on(function (array $requestOptions) use ($expectedPayload): bool {
                $headers = $requestOptions['headers'];
                $payload = $requestOptions['json'];

                $this->assertEquals($this->expectedHeaders(), $headers);
                $this->assertEquals($expectedPayload, $payload);

                return true;
            }))
            ->andReturn($mockResponse);

        $this->service->sendTextMessage($channelId, $message, $options);
    }

    public function testSendBlocksMessage()
    {
        $channelId = 'C123456';

        $block1 = new HeaderBlock(new TextObject('Test Header'));
        $block2 = new DividerBlock();

        $blocks = [$block1, $block2];

        $blocksAsArray = array_map(function (Block $block): array {
            return $block->toArray();
        }, $blocks);

        $expectedPayload = [
            'channel' => $channelId,
            'blocks' => $blocksAsArray,
        ];

        $expectedUrl = sprintf('%s/chat.postMessage', $this->apiUrl);

        $mockResponse = \Mockery::mock(ResponseInterface::class);
        $this->httpClient->shouldReceive('request')
            ->once()
            ->with('POST', $expectedUrl, \Mockery::on(function (array $requestOptions) use ($expectedPayload): bool {
                $headers = $requestOptions['headers'];
                $payload = $requestOptions['json'];

                $this->assertEquals($this->expectedHeaders(), $headers);
                $this->assertEquals($expectedPayload, $payload);

                return true;
            }))
            ->andReturn($mockResponse);

        $this->service->sendBlocksMessage($channelId, $blocks);
    }

    public function sendTextMessageOptionsDataProvider(): array
    {
        return [
            'empty options' => [
                [],
                []
            ],
            'all the basics' => [
                [
                    'username' => 'Test User',
                    'icon' => [
                        'url' => 'https://example.com',
                    ],
                    'unfurl' => [
                        'media' => true,
                        'links' => false,
                    ],
                    'thread' => [
                        'ts' => 'test',
                        'send_to_channel' => true,
                    ],
                    'markdown' => true,
                    'parse' => 'test-parse',
                    'metadata' => ['key' => 'value'],
                ],
                [
                    'username' => 'Test User',
                    'icon_url' => 'https://example.com',
                    'unfurl_media' => true,
                    'unfurl_links' => false,
                    'thread_ts' => 'test',
                    'reply_broadcast' => true,
                    'mrkdwn' => true,
                    'parse' => 'test-parse',
                    'metadata' => ['key' => 'value'],
                ],
            ],
            'icon.emoji overrides icon.url' => [
                [
                    'icon' => [
                        'emoji' => ':test:',
                        'url' => 'https://example.com',
                    ],
                ],
                [
                    'icon_emoji' => ':test:',
                ]
            ],
        ];
    }

    protected function expectedHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->botToken,
            'Content-Type' => 'application/json;charset=utf8'
        ];
    }
}
