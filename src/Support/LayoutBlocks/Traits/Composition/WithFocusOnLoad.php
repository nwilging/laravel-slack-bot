<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition;

trait WithFocusOnLoad
{
    protected ?bool $focusOnLoad = null;

    public function withFocusOnLoad(bool $focusOnLoad = true): self
    {
        $this->focusOnLoad = $focusOnLoad;
        return $this;
    }
}
