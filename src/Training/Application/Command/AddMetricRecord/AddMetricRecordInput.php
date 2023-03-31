<?php

declare(strict_types=1);

namespace Training\Application\Command\AddMetricRecord;

readonly class AddMetricRecordInput
{
    /**
     * @param  array<string, int>  $values
     */
    public function __construct(
        public string $trainingId,
        public string $date,
        public array $values,
    ) {
    }
}
