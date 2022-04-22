<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

class MarkdownObject extends TextObject
{
    protected string $type = 'mrkdwn';

    public function __construct(string $text)
    {
        parent::__construct($text);
    }
}
