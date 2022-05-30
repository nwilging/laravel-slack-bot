<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support;

class SlackCommandRequest
{
    /**
     * @deprecated
     * Verification token
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $token;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $teamId;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $teamDomain;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $channelId;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $channelName;

    /**
     * The ID of the user who triggered the command
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $userId;

    /**
     * @deprecated https://api.slack.com/interactivity/slash-commands#escaping_users_warning
     * The plain text name of the user who triggered the command
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $username;

    /**
     * The command that was typed in to trigger this request
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $command;

    /**
     * Array of command arguments from the `text` parameter of the original Slack request
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var array
     */
    public array $commandArgs;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $apiAppId;

    /**
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var bool
     */
    public bool $isEnterpriseInstall;

    /**
     * A temporary webhook URL that you can use to generate messages responses.
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $responseUrl;

    /**
     * A short-lived ID that will let your app open a modal.
     *
     * @see https://api.slack.com/interactivity/slash-commands#app_command_handling
     * @var string
     */
    public string $triggerId;
}
