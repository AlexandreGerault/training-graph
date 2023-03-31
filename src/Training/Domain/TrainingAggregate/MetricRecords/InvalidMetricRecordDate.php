<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate\MetricRecords;

class InvalidMetricRecordDate extends \InvalidArgumentException
{
    public function __construct(string $date)
    {
        parent::__construct(
            message: sprintf(
                'Invalid date for metric record: %s. Expected format: Y-m-d',
                $date,
            ),
        );
    }
}
