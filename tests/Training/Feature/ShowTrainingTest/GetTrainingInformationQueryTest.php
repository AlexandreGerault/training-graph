<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ShowTrainingTest;

use Database\Factories\Training\MetricRecordFactory;
use Database\Factories\Training\TrainingFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Training\Application\Query\ShowTraining\GetGenericTrainingInformationQuery;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingType;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('fetches the information of a training', function () {
    $trainingModel = TrainingFactory::new()->create();

    /** @var GetGenericTrainingInformationQuery $query */
    $query = app()->get(GetGenericTrainingInformationQuery::class);

    $trainingInformation = $query->execute(TrainingId::fromString($trainingModel->uuid));

    expect($trainingInformation->name)->toBe($trainingModel->name)
        ->and($trainingInformation->description)->toBe($trainingModel->description);
});

it('fetches metric records for a cs go aim training', function () {
    $trainingModel = TrainingFactory::new()
        ->state(['training_type' => TrainingType::CsGoAimReflexTraining->value])
        ->create();

    $metricRecordModel = $trainingModel->metricRecords()->create(MetricRecordFactory::new()->raw());

    $metricRecordModel->values()->createMany([
        [
            'key' => 'targetCount',
            'value' => 10,
        ],
        [
            'key' => 'hitCount',
            'value' => 10,
        ],
        [
            'key' => 'missCount',
            'value' => 10,
        ],
    ]);

    /** @var GetGenericTrainingInformationQuery $query */
    $query = app()->get(GetGenericTrainingInformationQuery::class);

    $trainingInformation = $query->execute(TrainingId::fromString($trainingModel->uuid));

    expect($trainingInformation->metricRecords)->toHaveCount(1);
});
