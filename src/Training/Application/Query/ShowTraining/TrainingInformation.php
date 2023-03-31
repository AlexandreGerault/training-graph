<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Training\Domain\TrainingAggregate\MetricRecord;

class TrainingInformation
{
    /**
     * @param  iterable<string>  $metricColumns
     * @param  array<MetricRecord>  $metricRecords
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
        public iterable $metricColumns,
        public array $metricRecords,
        public GraphData $graphData,
    ) {
    }
}
