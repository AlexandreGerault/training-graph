<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

readonly class TrainingSnapshot
{
    /**
     * @param  array<MetricRecord>  $metricRecords
     */
    public function __construct(
        public TrainingId $id,
        public GameId $gameId,
        public UserId $userId,
        public TrainingType $trainingType,
        public string $name,
        public string $description,
        public array $metricRecords = [],
    ) {
    }
}
