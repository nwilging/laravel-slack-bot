<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\ConfirmationDialogObject;

trait WithConfirmationDialog
{
    protected ?ConfirmationDialogObject $confirmationDialog = null;

    /**
     * A confirm object that defines an optional confirmation dialog
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#confirm
     *
     * @param ConfirmationDialogObject $confirmationDialog
     * @return $this
     */
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
