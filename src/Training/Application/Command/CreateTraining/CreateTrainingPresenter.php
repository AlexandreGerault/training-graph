<?php

declare(strict_types=1);

namespace Training\Application\Command\CreateTraining;

use Training\Domain\TrainingAggregate\TrainingSnapshot;

interface CreateTrainingPresenter
{
    public function trainingCreated(TrainingSnapshot $training): void;

    public function failedToSaveTraining(TrainingSnapshot $training): void;
}
