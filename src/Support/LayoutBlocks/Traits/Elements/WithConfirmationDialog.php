<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;

trait WithConfirmationDialog
{
    protected ?ConfirmationDialogObject $confirmationDialog = null;

    public function withConfirmationDialog(ConfirmationDialogObject $confirmationDialog): self
    {
        $this->confirmationDialog = $confirmationDialog;
        return $this;
    }

    protected function mergeConfirmationDialog(array $mergeWith): array
    {
        return array_merge($mergeWith, [
            'confirm' => ($this->confirmationDialog) ? $this->confirmationDialog->toArray() : null,
        ]);
    }
}
