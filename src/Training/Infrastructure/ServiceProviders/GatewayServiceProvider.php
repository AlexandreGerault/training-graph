<?php

declare(strict_types=1);

namespace Training\Infrastructure\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Training\Domain\Gateway\TrainingGateway;
use Training\Infrastructure\Gateway\EloquentTrainingRepository;

class GatewayServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            abstract: TrainingGateway::class,
            concrete: EloquentTrainingRepository::class,
        );
    }
}
