<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Slack Block Element
 * @see https://api.slack.com/reference/block-kit/block-elements
 */
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
    public const TYPE_TIME_PICKER = 'timepicker';
    public const TYPE_SELECT_MENU_STATIC = 'static_select';
    public const TYPE_SELECT_MENU_EXTERNAL = 'external_select';
    public const TYPE_SELECT_MENU_USERS = 'users_select';
    public const TYPE_SELECT_MENU_CONVERSATIONS = 'conversations_select';
    public const TYPE_SELECT_MENU_CHANNELS = 'channels_select';

    /**
     * The Slack-API compatible type of this element
     *
     * @return string
     */
    public abstract function getType(): string;

    /**
     * The Blocks that this element is compatible with
     *
     * @return string[]
     */
    public abstract function compatibleWith(): array;

    /**
     * The Slack-API compatible array for this element
     *
     * @return string[]
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
