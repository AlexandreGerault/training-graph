<?php

namespace Tests\Training\Infrastructure;

use Database\Factories\Training\GameFactory;
use Database\Factories\Training\TrainingFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use Tests\TestCase;
use Training\Domain\TrainingAggregate\GameId;
use Training\Domain\TrainingAggregate\MetricRecords\CsGoAimReflexTrainingMetricRecord;
use Training\Domain\TrainingAggregate\Training;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Domain\TrainingAggregate\UserId;
use Training\Infrastructure\Gateway\EloquentTrainingRepository;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('saves a fresh created training using Eloquent', function () {
    $trainingGateway = app()->get(EloquentTrainingRepository::class);

    $game = GameFactory::new()->create();
    $user = UserFactory::new()->create();

    $training = Training::create(
        gameId: GameId::fromString($game->uuid),
        userId: UserId::fromString($user->uuid),
        trainingType: TrainingType::CsGoAimReflexTraining,
        name: 'Test training',
        description: 'Test description',
    );

    $trainingGateway->save($training->snapshot());

    assertDatabaseHas('trainings', [
        'name' => 'Test training',
        'description' => 'Test description',
    ]);
    assertDatabaseMissing('metric_records', [
        'training_id' => $training->id()->get(),
    ]);
});

it('updates a training with metric records', function () {
    $trainingModel = TrainingFactory::new()->create();

    /** @var EloquentTrainingRepository $trainingGateway */
    $trainingGateway = app()->get(EloquentTrainingRepository::class);

    $training = $trainingGateway->getTrainingById($trainingModel->uuid);
    $training->addMetricRecord(
        CsGoAimReflexTrainingMetricRecord::fromArray(
            date: '2023-09-28',
            values: [
                'targetCount' => 10,
                'hitCount' => 5,
                'missCount' => 5,
            ])
    );

    $trainingGateway->save($training->snapshot());

    assertDatabaseHas('trainings', [
        'uuid' => $trainingModel->uuid,
    ]);
    assertDatabaseHas('metric_records', [
        'training_id' => $trainingModel->uuid,
    ]);
    assertDatabaseHas('metric_record_values', [
        'metric_record_id' => $trainingModel->metricRecords->first()->uuid,
        'key' => 'targetCount',
        'value' => 10,
    ]);
    assertDatabaseHas('metric_record_values', [
        'metric_record_id' => $trainingModel->metricRecords->first()->uuid,
        'key' => 'hitCount',
        'value' => 5,
    ]);
    assertDatabaseHas('metric_record_values', [
        'metric_record_id' => $trainingModel->metricRecords->first()->uuid,
        'key' => 'missCount',
        'value' => 5,
    ]);
});
