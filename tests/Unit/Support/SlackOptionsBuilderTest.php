<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support;

use Nwilging\LaravelSlackBot\Support\SlackOptionsBuilder;
use Nwilging\LaravelSlackBotTests\TestCase;

class SlackOptionsBuilderTest extends TestCase
{
    public function testEmpty()
    {
        $builder = new SlackOptionsBuilder();
        $this->assertEmpty($builder->toArray());
    }

    public function testAllOptions()
    {
        $builder = new SlackOptionsBuilder();

        $builder
            ->username('Test Bot')
            ->iconUrl('https://example.com')
            ->iconEmoji(':test:')
            ->unfurlMedia()
            ->unfurlLinks()
            ->threadTs('test-ts')
            ->threadReplySendToChannel()
            ->linkNames()
            ->metadata(['key' => 'val'])
            ->parse('test-parse')
            ->markdown();

        $this->assertEquals([
            'username' => 'Test Bot',
            'icon' => [
                'url' => 'https://example.com',
                'emoji' => ':test:',
            ],
            'unfurl' => [
                'media' => true,
                'links' => true,
            ],
            'thread' => [
                'ts' => 'test-ts',
                'send_to_channel' => true,
            ],
            'link_names' => true,
            'metadata' => ['key' => 'val'],
            'parse' => 'test-parse',
            'markdown' => true,
        ], $builder->toArray());
    }
}
