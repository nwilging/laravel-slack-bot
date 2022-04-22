<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits;

trait HasActionId
{
    protected string $actionId;

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'action_id' => $this->actionId,
        ];
    }
}
