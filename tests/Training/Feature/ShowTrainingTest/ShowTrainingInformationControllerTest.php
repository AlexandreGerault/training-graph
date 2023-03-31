<?php

namespace Tests\Training\Feature\ShowTrainingTest;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Training\Application\Query\ShowTraining\GetGenericTrainingInformationQuery;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\swap;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('shows a training information page', function () {
    swap(
        GetGenericTrainingInformationQuery::class,
        new GetGenericTrainingInformationQueryDumb(),
    );

    $user = UserFactory::new()->create();

    actingAs($user)->get(route('training.show', ['training' => 'some-id']))
        ->assertOk()
        ->assertSee('Training name')
        ->assertSee('Training description');
});

it('shows a 404 page when the training is not found', function () {
    swap(
        GetGenericTrainingInformationQuery::class,
        new GetGenericTrainingInformationQueryDumb(notFound: true),
    );

    $user = UserFactory::new()->create();

    actingAs($user)->get(route('training.show', ['training' => 'some-id']))
        ->assertNotFound();
});
