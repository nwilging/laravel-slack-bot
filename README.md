# Laravel Slack Bot

A robust Slack messaging integration for Laravel

---

### About

While Slack Incoming Webhooks are powerful, direct API interaction is powerful-er - or
something like that.

This package leverages Slack [bot tokens](https://api.slack.com/authentication/token-types#bot) to
interact with the Slack API. This allows the integration to do things such as search channels
and post messages - both plain and rich text - to any channel* in a workspace.

_* any public channel, or private channel that the Slack App bot is a member of_

---

# Installation

### Pre Requisites

1. Laravel v8+
2. PHP 7.4+

### Install with Composer

```
composer require nwilging/laravel-slack-bot
```

### Configure

Use [this guide](https://api.slack.com/authentication/basics) to create your Slack App. Most
integrations will use the following scopes. You may add additional OAuth scopes if needed.
* `channels:read`
* `chat:write`
* `chat:write.customize`
* `groups:read`
* `groups:write`
* `im:read`
* `mpim:read`

To configure your `.env`, simply add the following variable:
```
SLACK_API_BOT_TOKEN=xoxb-your-bot-token
```

# Basic Usage

This package can be used automatically with Laravel notifications. Add `slack` to the
`via()` array of your notification and a `toSlack()` method that returns an array:
```phpt
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SlackNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack(): array
    {
        return [
            'contentType' => 'text',
            'message' => 'test plain text message',
            'channelId' => 'C012345',
        ];
    }
}
```

The `channelId` here is the ID of the channel you wish to send to. It is recommended to
maintain a list of channel names and their associated IDs (such as in a database or configuration
file) so that they may be supplied to the notification in whichever way you'd like.

Read more on Usage for information on the `SlackApiService` which can provide you channel
data (including ID) by a channel name.

# Advanced Usage

This package also provides a `SlackApiService` and a handful of supporting classes such
as layout builders, layout blocks, elements, and composition objects. The most common usage
outside of sending plain text messages would be to send rich text messages using the layout
builders and related components. You can also go further to make use of the `SlackApiService`.

## Slack API Service

#### Contract: `Nwilging\LaravelSlackBot\Contracts\SlackApiServiceContract`
#### Methods:
* `listConversations` - Returns a paginated list of channels and groups
  * `int $limit = 100` - Page limit (default 100)
  * `?string $cursor = null` - Page cursor, used to fetch a new page
  * `bool $excludeArchived = false` - Flag to exclude archived channels and groups
  * `?string $teamId = null` - The team ID to list conversations for ([required if token
belongs to an org-wide app](https://api.slack.com/methods/conversations.list#arg_team_id))
  * `bool $includePrivate = true` - Flag to include private channels and groups (will only
show channels the app is a member of)
* `getChannelByName` - Retrieves channel data using a given name
  * `string $name` - The name of the channel to retrieve
* `sendTextMessage` - Send a plain text message
  * `string $channelId` - The ID of the channel to send to
  * `string $message` - The message text to send (may include markdown)
  * `array $options = []` - [Message options](#message-options)
* `sendBlocksMessage` - Send a message using [layout blocks](#layout-blocks)
  * `string $channelId` - The ID of the channel to send to
  * `array $blocks` - Array of `Block`s
  * `array $options = []` - [Message options](#message-options)

## Message Options
Message options should be passed as an array with the following schema:
```
{
    username?: string,
    icon?: {
      emoji?: string,
      url?: string,
    },
    unfurl?: {
      'media': bool,
      'links': bool,
    },
    thread?: {
      ts?: string,
      send_to_channel?: bool,
    },
    link_names?: bool,
    metadata?: array,
    parse?: string,
    markdown?: bool,
}
```
These options are essentially the [optional arguments from `chat.postMessage`](https://api.slack.com/methods/chat.postMessage#args).

There is a `SlackOptionsBuilder` support class that makes building this array more expressive:
```phpt
use Nwilging\LaravelSlackBot\Support\SlackOptionsBuilder;

$builder = new SlackOptionsBuilder();

$builder
    ->username('My Bot') // Set a custom username
    ->iconUrl('https://...') // URL to icon (overrides iconEmoji)
    ->iconEmoji(':white_check_mark:') // Sets icon to an emoji
    ->unfurlMedia()
    ->unfurlLinks()
    ->threadTs('ThreadTS')
    ->threadReplySendToChannel() // Whether or not to send reply to channel when replying to a thread
    ->linkNames()
    ->parse('...')
    ->markdown() // Enable markdown (or disable by passing `false`)
    ->metadata([]);

// Pass this to `SlackApiService`
$apiServiceCompliantOptionsArray = $builder->toArray();
```

## Layout Blocks

The layout blocks implementation generally follows [Slack's layout blocks](https://api.slack.com/reference/block-kit/blocks)
design.

### Layout Builder

There is a layout `Builder` located at `Nwilging\LaravelSlackBot\Support\LayoutBuilder\Builder`,
implementing contract `Nwilging\LaravelSlackBot\Contracts\Support\LayoutBuilder\BuilderContract`.

The builder aims to provide expressive methods to build basic, yet robust, messages. This
is a useful tool for building your notification in its `toSlack()` method.

```phpt
use Nwilging\LaravelSlackBot\Support\LayoutBuilder\Builder;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Blocks;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements;

$layouBuilder = new Builder();

// Create a button element with text
$buttonElement = new Elements\ButtonElement(
    $layoutBuilder->withPlainText('Button Text'), // Helper method to create a TextObject
    'action-id'
);

// Add the button element to an actions block
$actionsBlock = new Blocks\ActionsBlock([$buttonElement]);

$layoutBuilder
    ->header('Header Text')
    ->divider()
    ->addBlock($actionsBlock);

// Pass this to `sendBlocksMessage`
$apiServiceCompliantBlocksArray = $layoutBuilder->getBlocks();
```
