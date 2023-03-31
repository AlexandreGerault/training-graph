<?php

declare(strict_types=1);

namespace Training\Infrastructure\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Training\Application\Query\ListTrainings\ListTrainingEloquentQuery;
use Training\Application\Query\ListTrainings\ListTrainingsQuery;
use Training\Application\Query\ShowTraining\GetEloquentGenericTrainingInformationQuery;
use Training\Application\Query\ShowTraining\GetGenericTrainingInformationQuery;

class QueryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            GetGenericTrainingInformationQuery::class,
            GetEloquentGenericTrainingInformationQuery::class,
        );

        $this->app->bind(
            ListTrainingsQuery::class,
            ListTrainingEloquentQuery::class,
        );
    }
}
