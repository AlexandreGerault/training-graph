<?php

declare(strict_types=1);

namespace Tests\Training\Feature\CreateTrainingTest;

use Tests\Training\TestDoubles\InMemoryTrainingGateway;
use Training\Application\Command\CreateTraining\CreateTrainingInput;
use Training\Application\Command\CreateTraining\CreateTrainingUseCase;

it('creates a training', function () {
    $trainingGateway = new InMemoryTrainingGateway([]);

    $input = new CreateTrainingInput(
        gameId: 'csgo',
        userId: 'some-user-id',
        trainingType: 'cs_go_aim_reflex_training',
        name: 'Aim training',
        description: 'Improve your aim reflexes and become a better shooter',
    );

    $presenter = new CreateTrainingTestPresenter();

    $createTraining = new CreateTrainingUseCase($trainingGateway);

    $createTraining->execute($input, $presenter);

    expect($presenter->trainingCreated)->toBeTrue()
        ->and($presenter->training->name)->toBe('Aim training')
        ->and($presenter->training->id)->not->toBeNull()
        ->and($trainingGateway)->toHaveCount(1);
});

it('handle save failure', function () {
    $trainingGateway = new InMemoryTrainingGateway([]);
    $trainingGateway->failOnSave = true;

    $input = new CreateTrainingInput(
        gameId: 'csgo',
        userId: 'some-user-id',
        trainingType: 'cs_go_aim_reflex_training',
        name: 'Aim training',
        description: 'Improve your aim reflexes and become a better shooter',
    );

    $presenter = new CreateTrainingTestPresenter();

    $createTraining = new CreateTrainingUseCase($trainingGateway);

    $createTraining->execute($input, $presenter);

    expect($presenter->trainingCreated)->toBeFalse()
        ->and($trainingGateway)->toHaveCount(0);
});
