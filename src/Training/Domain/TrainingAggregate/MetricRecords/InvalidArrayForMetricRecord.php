<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate\MetricRecords;

class InvalidArrayForMetricRecord extends \InvalidArgumentException
{
    /**
     * @param  array<array-key, int>  $values
     */
    public function __construct(array $values, string $metricRecordClass)
    {
        parent::__construct(
            message: sprintf(
                'Invalid array for metric record %s: %s',
                $metricRecordClass,
                json_encode($values),
            ),
        );
    }
}
