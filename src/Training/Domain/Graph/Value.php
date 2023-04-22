<?php

declare(strict_types=1);

namespace Training\Domain\Graph;

use MathPHP\Probability\Distribution\Continuous\StudentT;

readonly class Value implements \JsonSerializable
{
    public ?float $min;

    public ?float $max;

    public function __construct(
        public float $value,
        float $std,
        float $count,
    ) {
        if ($count > 0) {
            $studentDistribution = new StudentT($count);
            $quantile = $studentDistribution->inverse(0.95);

            $this->min = $this->value - $quantile * $std;
            $this->max = $this->value + $quantile * $std;

            return;
        }

        $this->min = null;
        $this->max = null;
    }

    public function jsonSerialize(): array
    {
        return [
            'y' => $this->value,
            'yMin' => $this->min,
            'yMax' => $this->max,
        ];
    }
}
