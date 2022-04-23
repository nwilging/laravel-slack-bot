<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\MultiSelect;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MultiSelectElementCompatibility;

abstract class MultiSelect extends Element
{
    use MultiSelectElementCompatibility, WithFocusOnLoad, WithConfirmationDialog;

    protected string $actionId;

    protected TextObject $placeholder;

    protected ?int $maxSelectedItems = null;

    protected function __construct(string $actionId, TextObject $placeholder)
    {
        $this->actionId = $actionId;
        $this->placeholder = $placeholder;
    }

    public function maxSelectedItems(int $maxSelectedItems): self
    {
        $this->maxSelectedItems = $maxSelectedItems;
        return $this;
    }

    public function toArray(): array
    {
        return $this->mergeConfirmationDialog([
            'type' => $this->getType(),
            'action_id' => $this->actionId,
            'placeholder' => $this->placeholder->toArray(),
            'focus_on_load' => $this->focusOnLoad,
            'max_selected_items' => $this->maxSelectedItems,
        ]);
    }
}
