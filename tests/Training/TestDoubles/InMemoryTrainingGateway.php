<?php

declare(strict_types=1);

namespace Tests\Training\TestDoubles;

use PHPUnit\Framework\Assert;
use Training\Domain\Gateway\TrainingGateway;
use Training\Domain\TrainingAggregate\Training;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

class InMemoryTrainingGateway implements TrainingGateway, \Countable
{
    public bool $failOnSave = false;

    public bool $saved = false;

    /**
     * @param  TrainingSnapshot[]  $trainings
     */
    public function __construct(private array $trainings = [])
    {
        foreach ($this->trainings as $training) {
            Assert::assertInstanceOf(
                expected: TrainingSnapshot::class,
                actual: $training,
                message: 'Training must be an instance of '.TrainingSnapshot::class,
            );
        }
    }

    public function count(): int
    {
        return count($this->trainings);
    }

    public function save(TrainingSnapshot $snapshot): void
    {
        if ($this->failOnSave) {
            throw new \Exception('Failed to save training');
        }

        $this->trainings[] = $snapshot;
        $this->saved = true;
    }

    public function last(): TrainingSnapshot
    {
        return end($this->trainings);
    }

    public function getTrainingById(string $trainingId): Training
    {
        foreach ($this->trainings as $training) {
            if ($training->id->get() === $trainingId) {
                return Training::fromSnapshot($training);
            }
        }

        throw new \Exception('Training not found');
    }

    public function assertTrainingSaved(): void
    {
        Assert::assertTrue($this->saved);
    }
}
