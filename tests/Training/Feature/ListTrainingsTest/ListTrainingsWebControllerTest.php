<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Laravel\actingAs;

uses(
    TestCase::class,
    RefreshDatabase::class,
);

it('show a list of trainings', function () {
    $user = UserFactory::new()->create();

    actingAs($user)->get(route('training.list'))
        ->assertOk();
});
