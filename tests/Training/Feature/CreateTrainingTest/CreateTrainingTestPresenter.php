<?php

declare(strict_types=1);

namespace Tests\Training\Feature\CreateTrainingTest;

use Training\Application\Command\CreateTraining\CreateTrainingPresenter;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

class CreateTrainingTestPresenter implements CreateTrainingPresenter
{
    public bool $trainingCreated = false;

    public TrainingSnapshot $training;

    public function trainingCreated(TrainingSnapshot $training): void
    {
        $this->trainingCreated = true;
        $this->training = $training;
    }

    public function failedToSaveTraining(TrainingSnapshot $training): void
    {
    }
}
