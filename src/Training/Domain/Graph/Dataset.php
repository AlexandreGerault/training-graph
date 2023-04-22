<?php

declare(strict_types=1);

namespace Training\Domain\Graph;

class Dataset implements \JsonSerializable
{
    /**
     * @param string $name
     * @param array<Value> $values
     */
    public function __construct(
        public string $name,
        public array $values,
    ) {
    }

    /**
     * @return array{label: string, data: array<int|float>}
     */
    public function jsonSerialize(): array
    {
        return [
            'label' => $this->name,
            'data' => $this->values,
        ];
    }
}
