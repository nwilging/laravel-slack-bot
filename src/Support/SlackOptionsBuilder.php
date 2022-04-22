<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support;

use Illuminate\Contracts\Support\Arrayable;

class SlackOptionsBuilder implements Arrayable
{
    protected array $options = [];

    public function username(string $username): self
    {
        $this->options['username'] = $username;
        return $this;
    }

    public function iconUrl(string $url): self
    {
        if (empty($this->options['icon'])) {
            $this->options['icon'] = [];
        }

        $this->options['icon']['url'] = $url;
        return $this;
    }

    public function iconEmoji(string $emoji): self
    {
        if (empty($this->options['icon'])) {
            $this->options['icon'] = [];
        }

        $this->options['icon']['emoji'] = $emoji;
        return $this;
    }

    public function unfurlMedia(bool $unfurl = true): self
    {
        if (empty($this->options['unfurl'])) {
            $this->options['unfurl'] = [];
        }

        $this->options['unfurl']['media'] = $unfurl;
        return $this;
    }

    public function unfurlLinks(bool $unfurl = true): self
    {
        if (empty($this->options['unfurl'])) {
            $this->options['unfurl'] = [];
        }

        $this->options['unfurl']['links'] = $unfurl;
        return $this;
    }

    public function threadTs(string $ts): self
    {
        if (empty($this->options['thread'])) {
            $this->options['thread'] = [];
        }

        $this->options['thread']['ts'] = $ts;
        return $this;
    }

    public function threadReplySendToChannel(bool $sendToChannel = true): self
    {
        if (empty($this->options['thread'])) {
            $this->options['thread'] = [];
        }

        $this->options['thread']['send_to_channel'] = $sendToChannel;
        return $this;
    }

    public function linkNames(bool $linkNames = true): self
    {
        $this->options['link_names'] = $linkNames;
        return $this;
    }

    public function metadata(array $metadata): self
    {
        $this->options['metadata'] = $metadata;
        return $this;
    }

    public function parse(string $parse): self
    {
        $this->options['parse'] = $parse;
        return $this;
    }

    public function markdown(bool $markdown = true): self
    {
        $this->options['markdown'] = $markdown;
        return $this;
    }

    public function toArray(): array
    {
        return $this->options;
    }
}
