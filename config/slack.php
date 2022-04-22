<?php
declare(strict_types=1);

return [
    'bot_token' => env('SLACK_API_BOT_TOKEN'),
    'api_url' => env('SLACK_API_URL', 'https://slack.com/api'),
];
