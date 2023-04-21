<?php

namespace Tests\Training\Feature\CreateTrainingTest;

use Database\Factories\Training\GameFactory;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\swap;
use Tests\TestCase;
use Tests\Training\TestDoubles\InMemoryTrainingGateway;
use Training\Domain\Gateway\TrainingGateway;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('should redirect unauthenticated people', function () {
    $this->get(route('training.create'))
        ->assertRedirect(route('login'));
});

it('should create training', function () {
    $trainingGateway = swap(
        TrainingGateway::class,
        new InMemoryTrainingGateway([]),
    );

    $user = UserFactory::new()->create();
    GameFactory::new()->create();

    actingAs($user)
        ->post(route('training.store'), [
            'gameId' => 'csgo',
            'trainingType' => 'cs_go_aim_reflex_training',
            'name' => 'Test training',
            'description' => 'Test description',
        ])
        ->assertRedirect()
        ->assertRedirect(route('training.show', ['training' => $trainingGateway->last()->id->get()]));
});

it('adds a flash error message and redirects when an error occurred', function () {
    $inMemoryTrainingGateway = new InMemoryTrainingGateway([]);
    $inMemoryTrainingGateway->failOnSave = true;

    swap(
        TrainingGateway::class,
        $inMemoryTrainingGateway,
    );

    $user = UserFactory::new()->create();
    GameFactory::new()->create();

    actingAs($user)
        ->post(route('training.store'), [
            'gameId' => 'csgo',
            'trainingType' => 'cs_go_aim_reflex_training',
            'name' => 'Test training',
            'description' => 'Test description',
        ])
        ->assertRedirect(route('training.create'))
        ->assertSessionHasErrors();
});
