<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Elements\SelectMenu;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Block;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\TextObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Composition\WithFocusOnLoad;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements\WithConfirmationDialog;

abstract class SelectMenu extends Element
{
    use WithFocusOnLoad, WithConfirmationDialog;

    protected string $actionId;

    protected TextObject $placeholder;

    protected function __construct(string $actionId, TextObject $placeholder)
    {
        $this->actionId = $actionId;
        $this->placeholder = $placeholder;
    }

    public function compatibleWith(): array
    {
        return [
            Block::TYPE_SECTION,
            Block::TYPE_ACTIONS,
            Block::TYPE_INPUT,
        ];
    }

    public function toArray(): array
    {
        return $this->mergeConfirmationDialog([
            'type' => $this->getType(),
            'action_id' => $this->actionId,
            'placeholder' => $this->placeholder->toArray(),
            'focus_on_load' => $this->focusOnLoad,
        ]);
    }
}
