<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks;

use Illuminate\Contracts\Support\Arrayable;

abstract class Element implements Arrayable
{
    public const TYPE_BUTTON = 'button';
    public const TYPE_CHECKBOXES = 'checkboxes';
    public const TYPE_DATEPICKER = 'datepicker';
    public const TYPE_IMAGE = 'image';
    public const TYPE_MULTI_SELECT_STATIC = 'multi_static_select';
    public const TYPE_MULTI_SELECT_EXTERNAL = 'multi_external_select';
    public const TYPE_MULTI_SELECT_USERS = 'multi_users_select';
    public const TYPE_MULTI_SELECT_CONVERSATIONS = 'multi_conversations_select';
    public const TYPE_MULTI_SELECT_CHANNELS = 'multi_channels_select';
    public const TYPE_OVERFLOW_MENU = 'overflow';
    public const TYPE_PLAIN_TEXT_INPUT = 'plain_text_input';
    public const TYPE_RADIO_BUTTON_GROUP = 'radio_buttons';

    public abstract function getType(): string;

    /**
     * @return string[]
     */
    public abstract function compatibleWith(): array;

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
