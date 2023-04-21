<?php

namespace Tests\Training\Feature\AddMetricRecord;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\swap;
use Tests\TestCase;
use Tests\Training\TestDoubles\InMemoryTrainingGateway;
use Training\Domain\Gateway\TrainingGateway;
use Training\Domain\TrainingAggregate\GameId;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingSnapshot;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Domain\TrainingAggregate\UserId;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('can add a cs go aim training record metric', function () {
    $trainingGateway = swap(
        TrainingGateway::class,
        new InMemoryTrainingGateway([
            new TrainingSnapshot(
                id: TrainingId::fromString('some-id'),
                gameId: GameId::fromString('csgo'),
                userId: UserId::fromString('some-user-id'),
                trainingType: TrainingType::CsGoAimReflexTraining,
                name: 'Test training',
                description: 'Test description',
                metricRecords: [],
            ),
        ]),
    );

    $user = UserFactory::new()->create();

    $response = actingAs($user)->post(
        uri: route('training.add_metric_record', 'some-id'),
        data: [
            'trainingId' => 'some-id',
            'date' => '2023-09-28',
            'values' => [
                'targetCount' => 10,
                'hitCount' => 10,
                'missCount' => 0,
            ],
        ]
    );

    $trainingId = $trainingGateway->last()->id->get();

    $response->assertRedirect(route('training.show', ['training' => $trainingId]));

    expect($trainingGateway->last()->metricRecords)->toHaveCount(1);
});
