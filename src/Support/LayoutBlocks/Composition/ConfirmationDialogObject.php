<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Confirmation Dialog Object
 * @see https://api.slack.com/reference/block-kit/composition-objects#confirm
 */
class ConfirmationDialogObject extends CompositionObject
{
    use MergesArrays;

    protected TextObject $title;

    protected TextObject $text;

    protected TextObject $confirmText;

    protected TextObject $denyText;

    protected ?string $confirmButtonStyle = null;

    public function __construct(TextObject $title, TextObject $text, TextObject $confirmText, TextObject $denyText)
    {
        $this->title = $title;
        $this->text = $text;
        $this->confirmText = $confirmText;
        $this->denyText = $denyText;
    }

    /**
     * Defines the color scheme applied to the confirm button.
     * A value of primary will display the button with a green background on desktop, or blue text on mobile.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#confirm__fields
     *
     * @return $this
     */
    public function confirmButtonPrimary(): self
    {
        $this->confirmButtonStyle = 'primary';
        return $this;
    }

    /**
     * Defines the color scheme applied to the confirm button.
     * A value of danger will display the button with a red background on desktop, or red text on mobile.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#confirm__fields
     *
     * @return $this
     */
    public function confirmButtonDanger(): self
    {
        $this->confirmButtonStyle = 'danger';
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'title' => $this->title->toArray(),
            'text' => $this->text->toArray(),
            'confirm' => $this->confirmText->toArray(),
            'deny' => $this->denyText->toArray(),
            'style' => $this->confirmButtonStyle,
        ]);
    }
}
