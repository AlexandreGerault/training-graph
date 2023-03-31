<?php

declare(strict_types=1);

namespace Training\Feature\ListTrainingsTest;

use Database\Factories\Training\TrainingFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Training\Application\Query\ListTrainings\ListTrainingsInput;
use Training\Application\Query\ListTrainings\ListTrainingsQuery;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('fetches one training', function () {
    $user = UserFactory::new()->create();

    TrainingFactory::new()
        ->for($user)
        ->create();

    /** @var ListTrainingsQuery $query */
    $query = app()->get(ListTrainingsQuery::class);

    $input = new ListTrainingsInput(userId: $user->uuid, page: 1, perPage: 10);

    $trainingList = $query->execute($input);

    expect($trainingList->getTrainings())->toHaveCount(1);
});

it('queries the correct page', function () {
    $user = UserFactory::new()->create();

    TrainingFactory::new()
        ->for($user)
        ->count(2)
        ->create();

    /** @var ListTrainingsQuery $query */
    $query = app()->get(ListTrainingsQuery::class);

    $input = new ListTrainingsInput(userId: $user->uuid, page: 2, perPage: 1);

    $trainingList = $query->execute($input);

    expect($trainingList->getTrainings())->toHaveCount(1)
        ->and($trainingList->lastPage)->toBe(2)
        ->and($trainingList->currentPage)->toBe(2);
});
