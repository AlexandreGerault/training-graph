<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ListTrainingsTest;

use Training\Application\Query\ListTrainings\ListTrainingsInput;
use Training\Application\Query\ListTrainings\ListTrainingsQuery;
use Training\Application\Query\ListTrainings\TrainingList;

class ListTrainingDumbQuery implements ListTrainingsQuery
{
    public function __construct(private bool $failed = false)
    {
    }

    public function execute(ListTrainingsInput $input): TrainingList
    {
        if ($this->failed) {
            throw new \Exception('Failed to fetch trainings');
        }

        return new TrainingList(
            trainings: [],
            currentPage: 1,
            lastPage: 1,
            perPage: 1,
        );
    }
}
