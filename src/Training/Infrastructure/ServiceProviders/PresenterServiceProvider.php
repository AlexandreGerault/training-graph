<?php

declare(strict_types=1);

namespace Training\Infrastructure\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Training\Application\Command\CreateTraining\CreateTrainingPresenter;
use Training\UI\Web\CreateTraining\CreateTrainingController;
use Training\UI\Web\CreateTraining\CreateTrainingWebPresenter;

class PresenterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->when(CreateTrainingController::class)
            ->needs(CreateTrainingPresenter::class)
            ->give(CreateTrainingWebPresenter::class);
    }
}
