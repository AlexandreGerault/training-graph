<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ListTrainingsTest;

use Training\Application\Query\ListTrainings\ListTrainingsPresenter;
use Training\Application\Query\ListTrainings\TrainingList;

class ListTrainingTestPresenter implements ListTrainingsPresenter
{
    public string $response;

    public function __construct()
    {
    }

    public function trainingsFetched(TrainingList $trainingList): void
    {
        $this->response = 'Training list';
    }

    public function failedToFetchTrainings(): void
    {
        $this->response = 'Failed to fetch trainings';
    }
}
