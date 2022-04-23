<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition;

trait WithFocusOnLoad
{
    protected ?bool $focusOnLoad = null;

    /**
     * Indicates whether the element will be set to autofocus within the view object.
     * Only one element can have this attribute set.
     *
     * @param bool $focusOnLoad
     * @return $this
     */
    public function withFocusOnLoad(bool $focusOnLoad = true): self
    {
        $this->focusOnLoad = $focusOnLoad;
        return $this;
    }
}
