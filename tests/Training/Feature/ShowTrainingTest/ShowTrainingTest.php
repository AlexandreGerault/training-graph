<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ShowTrainingTest;

use Training\Application\Query\ShowTraining\ShowTrainingUseCase;
use Training\Application\Query\ShowTraining\TrainingInformation;

it('shows a training', function () {
    $query = new GetGenericTrainingInformationQueryDumb();

    $presenter = new ShowTrainingTestPresenter();

    $useCase = new ShowTrainingUseCase($query);

    $useCase->execute('some-id', $presenter);

    expect($presenter->response())->toBeInstanceOf(TrainingInformation::class)
        ->and($presenter->response()->name)->toBe('Training name')
        ->and($presenter->response()->description)->toBe('Training description');
});

it('handle a training not found', function () {
    $query = new GetGenericTrainingInformationQueryDumb(notFound: true);

    $presenter = new ShowTrainingTestPresenter();

    $useCase = new ShowTrainingUseCase($query);

    $useCase->execute('some-id', $presenter);

    expect($presenter->response())->toBe('Training not found');
});
