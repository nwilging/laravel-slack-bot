<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\CompositionObject;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\MergesArrays;

/**
 * Dispatch Action Configuration Object
 * @see https://api.slack.com/reference/block-kit/composition-objects#dispatch_action_config
 */
class DispatchActionConfigurationObject extends CompositionObject
{
    use MergesArrays;

    /**
     * @var string[]
     */
    protected array $triggerActionsOn = [];

    /**
     * Payload is dispatched when user presses the enter key while the input is in focus.
     * Hint text will appear underneath the input explaining to the user to press enter to submit
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#dispatch_action_config__fields
     *
     * @return $this
     */
    public function onEnterPressed(): self
    {
        $this->triggerActionsOn[] = 'on_enter_pressed';
        return $this;
    }

    /**
     * Payload is dispatched when a character is entered (or removed) in the input.
     *
     * @see https://api.slack.com/reference/block-kit/composition-objects#dispatch_action_config__fields
     *
     * @return $this
     */
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
