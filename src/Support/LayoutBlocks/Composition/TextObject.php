<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class TextObject extends CompositionObject
{
    use MergesArrays;

    protected string $type = 'plain_text';

    protected string $text;

    protected ?bool $emoji = null;

    protected ?bool $verbatim = null;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function escapeEmojis(): self
    {
        $this->emoji = true;
        return $this;
    }

    public function verbatim(): self
    {
        if ($this->type !== 'mrkdwn') return $this;

        $this->verbatim = true;
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'type' => $this->type,
            'text' => $this->text,
            'emoji' => $this->emoji,
            'verbatim' => $this->verbatim,
        ]);
    }
}
