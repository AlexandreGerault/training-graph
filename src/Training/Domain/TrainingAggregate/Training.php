<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

class Training
{
    /**
     * @param  MetricRecord[]  $metricRecords
     */
    public function __construct(
        private TrainingId $id,
        private GameId $gameId,
        private UserId $userId,
        private TrainingType $trainingType,
        private string $name,
        private string $description,
        private array $metricRecords = [],
    ) {
    }

    public static function create(
        GameId $gameId,
        UserId $userId,
        TrainingType $trainingType,
        string $name,
        string $description
    ): Training {
        return new self(
            id: TrainingId::generate(),
            gameId: $gameId,
            userId: $userId,
            trainingType: $trainingType,
            name: $name,
            description: $description,
        );
    }

    public static function fromSnapshot(TrainingSnapshot $snapshot): Training
    {
        return new self(
            id: $snapshot->id,
            gameId: $snapshot->gameId,
            userId: $snapshot->userId,
            trainingType: $snapshot->trainingType,
            name: $snapshot->name,
            description: $snapshot->description,
            metricRecords: $snapshot->metricRecords,
        );
    }

    public function id(): TrainingId
    {
        return $this->id;
    }

    public function snapshot(): TrainingSnapshot
    {
        return new TrainingSnapshot(
            id: $this->id,
            gameId: $this->gameId,
            userId: $this->userId,
            trainingType: $this->trainingType,
            name: $this->name,
            description: $this->description,
            metricRecords: $this->metricRecords,
        );
    }

    public function addMetricRecord(MetricRecord $metricRecord): void
    {
        $this->metricRecords[] = $metricRecord;
    }

    public function trainingType(): TrainingType
    {
        return $this->trainingType;
    }
}
