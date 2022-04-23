<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Plain Text Object
 * @see https://api.slack.com/reference/block-kit/composition-objects#text
 */
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

    /**
     * Indicates whether emojis in a text field should be escaped into the colon emoji format.
     * This field is only usable when type is plain_text.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#text__fields
     *
     * @return $this
     */
    public function escapeEmojis(): self
    {
        $this->emoji = true;
        return $this;
    }

    /**
     * When set to false (as is default) URLs will be auto-converted into links, conversation names will be link-ified,
     * and certain mentions will be automatically parsed. Using a value of true will skip any preprocessing of this
     * nature, although you can still include manual parsing strings.
     * This field is only usable when type is mrkdwn.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#text__fields
     *
     * @return $this
     */
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
