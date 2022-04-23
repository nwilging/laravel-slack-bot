<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits\Elements;

use Illuminate\Contracts\Support\Arrayable;
use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Composition\OptionObject;

trait HasInitialOption
{
    /**
     * @var OptionObject|string|null
     */
    protected $initialOption = null;

    protected string $initialOptionKeyName = 'initial_option';

    /**
     * @param OptionObject|string $initialOption
     * @return $this
     */
    public function withInitialOption($initialOption): self
    {
        $this->initialOption = $initialOption;
        return $this;
    }

    protected function mergeInitialOption(array $toMergeWith = []): array
    {
        $formattedOption = null;
        if (is_string($this->initialOption)) {
            $formattedOption = $this->initialOption;
        } elseif ($this->initialOption instanceof Arrayable) {
            $formattedOption = $this->initialOption->toArray();
        }

        return array_merge($toMergeWith, [
            $this->initialOptionKeyName => $formattedOption,
        ]);
    }
}
