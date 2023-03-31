<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ListTrainingsTest;

use Training\Application\Query\ListTrainings\ListTrainingsInput;
use Training\Application\Query\ListTrainings\ListTrainingsUseCase;

it('show the listing of a user\'s training', function () {
    $query = new ListTrainingDumbQuery();

    $presenter = new ListTrainingTestPresenter();

    $useCase = new ListTrainingsUseCase($query);

    $input = new ListTrainingsInput(
        userId: 'some-id',
        page: 1,
        perPage: 1,
    );

    $useCase->execute($input, $presenter);

    expect($presenter->response)->toBe('Training list');
});

it('it failed to fetch trainings', function () {
    $query = new ListTrainingDumbQuery(failed: true);

    $presenter = new ListTrainingTestPresenter();

    $useCase = new ListTrainingsUseCase($query);

    $input = new ListTrainingsInput(
        userId: 'some-id',
        page: 1,
        perPage: 1,
    );

    $useCase->execute($input, $presenter);

    expect($presenter->response)->toBe('Failed to fetch trainings');
});
