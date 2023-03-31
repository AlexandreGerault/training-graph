<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

interface ListTrainingsPresenter
{
    public function trainingsFetched(TrainingList $trainingList): void;

    public function failedToFetchTrainings(): void;
}
