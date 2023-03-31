<?php

declare(strict_types=1);

namespace Training\Infrastructure\Gateway;

use Training\Domain\Gateway\TrainingGateway;
use Training\Domain\TrainingAggregate\GameId;
use Training\Domain\TrainingAggregate\Training;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingSnapshot;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Domain\TrainingAggregate\UserId;
use Training\Infrastructure\Model\TrainingModel;

class EloquentTrainingRepository implements TrainingGateway
{
    public function save(TrainingSnapshot $snapshot): void
    {
        $trainingModel = TrainingModel::updateOrCreate(
            attributes: ['uuid' => $snapshot->id->get()],
            values: [
                'game_id' => $snapshot->gameId->get(),
                'user_id' => $snapshot->userId->get(),
                'name' => $snapshot->name,
                'description' => $snapshot->description,
                'training_type' => $snapshot->trainingType->value,
            ]
        );

        if (count($snapshot->metricRecords) === 0) {
            return;
        }

        $metricRecordModel = $trainingModel->metricRecords()->create(['date' => $snapshot->metricRecords[0]->date()]);

        foreach ($snapshot->metricRecords as $metricRecord) {
            $values = $metricRecord->toArray();

            foreach ($values as $key => $value) {
                $metricRecordModel->values()->create([
                    'key' => $key,
                    'value' => $value,
                ]);
            }
        }
    }

    public function getTrainingById(string $trainingId): Training
    {
        $trainingModel = TrainingModel::query()->find($trainingId);

        $trainingModel->load(['game', 'user']);

        return new Training(
            id: TrainingId::fromString($trainingModel->uuid),
            gameId: GameId::fromString($trainingModel->game->uuid),
            userId: UserId::fromString($trainingModel->user->uuid),
            trainingType: TrainingType::CsGoAimReflexTraining,
            name: $trainingModel->name,
            description: $trainingModel->description,
        );
    }
}
