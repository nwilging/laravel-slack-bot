<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBot\Support\LayoutBlocks\Traits;

use Nwilging\LaravelSlackBot\Support\LayoutBlocks\Element;

trait HasElements
{
    /**
     * @var Element[]
     */
    protected array $elements = [];

    protected function elementsArray(): array
    {
        return array_map(function (Element $element): array {
            return $element->toArray();
        }, $this->elements);
    }
}
