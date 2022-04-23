<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

class DispatchActionConfigurationObject extends CompositionObject
{
    use MergesArrays;

    /**
     * @var string[]
     */
    protected array $triggerActionsOn = [];

    public function onEnterPressed(): self
    {
        $this->triggerActionsOn[] = 'on_enter_pressed';
        return $this;
    }

    public function onCharacterEntered(): self
    {
        $this->triggerActionsOn[] = 'on_character_entered';
        return $this;
    }

    public function toArray(): array
    {
        return $this->toMergedArray([
            'trigger_actions_on' => !empty($this->triggerActionsOn) ? $this->triggerActionsOn : null,
        ]);
    }
}
