<?php

declare(strict_types=1);

namespace Training\Domain\Graph;

readonly class Value
{
    public function __construct(
        public float $value,
        public float $min,
        public float $max,
    ) {
    }
}
