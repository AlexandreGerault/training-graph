<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

class GraphValue
{
    public function __construct(
        public float $value,
        public float $std,
        public int $count,
    ) {
    }
}
