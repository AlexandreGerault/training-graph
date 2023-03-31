<?php

declare(strict_types=1);

namespace Tests\Training\Feature\AddMetricRecord;

use Tests\Training\TestDoubles\InMemoryTrainingGateway;
use Training\Application\Command\AddMetricRecord\AddMetricRecordInput;
use Training\Application\Command\AddMetricRecord\AddMetricRecordUseCase;
use Training\Domain\TrainingAggregate\GameId;
use Training\Domain\TrainingAggregate\MetricRecords\InvalidArrayForMetricRecord;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingSnapshot;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Domain\TrainingAggregate\UserId;

it('can add a cs:go aim metric record', function () {
    $trainingId = 'some-id';

    $values = [
        'targetCount' => 10,
        'hitCount' => 10,
        'missCount' => 0,
    ];

    $input = new AddMetricRecordInput(
        trainingId: $trainingId,
        date: '2023-09-28',
        values: $values,
    );

    $presenter = new AddMetricRecordTestPresenter();

    $inMemoryTrainingGateway = new InMemoryTrainingGateway([
        $trainingId => new TrainingSnapshot(
            id: TrainingId::fromString($trainingId),
            gameId: GameId::fromString('csgo'),
            userId: UserId::fromString('some-user-id'),
            trainingType: TrainingType::CsGoAimReflexTraining,
            name: 'some-name',
            description: 'some-description',
        ),
    ]);

    $useCase = new AddMetricRecordUseCase($inMemoryTrainingGateway);

    $useCase->execute($input, $presenter);

    expect($presenter->training)->toBeInstanceOf(TrainingSnapshot::class)
        ->and($presenter->training->metricRecords)->toHaveCount(1);

    $inMemoryTrainingGateway->assertTrainingSaved();
});

it('can add League of Legends farm metric record', function () {
    $trainingId = 'some-id';

    $values = [
        'farmCount' => 10,
        'durationInSeconds' => 60,
    ];

    $input = new AddMetricRecordInput(
        trainingId: $trainingId,
        date: '2023-09-28',
        values: $values,
    );

    $presenter = new AddMetricRecordTestPresenter();

    $inMemoryTrainingGateway = new InMemoryTrainingGateway([
        $trainingId => new TrainingSnapshot(
            id: TrainingId::fromString($trainingId),
            gameId: GameId::fromString('lol'),
            userId: UserId::fromString('some-user-id'),
            trainingType: TrainingType::LoLFarmTraining,
            name: 'some-name',
            description: 'some-description',
        ),
    ]);

    $useCase = new AddMetricRecordUseCase($inMemoryTrainingGateway);

    $useCase->execute($input, $presenter);

    expect($presenter->training)->toBeInstanceOf(TrainingSnapshot::class)
        ->and($presenter->training->metricRecords)->toHaveCount(1);
});

it('raises an exception when input values does not match game type', function () {
    $trainingId = 'some-id';

    $values = [
        'farmCount' => 10,
        'durationInSeconds' => 60,
    ];

    $input = new AddMetricRecordInput(
        trainingId: $trainingId,
        date: '2023-09-28',
        values: $values,
    );

    $presenter = new AddMetricRecordTestPresenter();

    $inMemoryTrainingGateway = new InMemoryTrainingGateway([
        $trainingId => new TrainingSnapshot(
            id: TrainingId::fromString($trainingId),
            gameId: GameId::fromString('lol'),
            userId: UserId::fromString('some-user-id'),
            trainingType: TrainingType::CsGoAimReflexTraining,
            name: 'some-name',
            description: 'some-description',
        ),
    ]);

    $useCase = new AddMetricRecordUseCase($inMemoryTrainingGateway);

    $useCase->execute($input, $presenter);

    expect($presenter->training)->toBeInstanceOf(TrainingSnapshot::class)
        ->and($presenter->training->metricRecords)->toHaveCount(1);
})->throws(InvalidArrayForMetricRecord::class);
