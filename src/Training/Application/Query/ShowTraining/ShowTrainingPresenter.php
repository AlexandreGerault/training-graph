<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

interface ShowTrainingPresenter
{
    public function trainingFound(TrainingInformation $trainingInformation): void;

    public function trainingNotFound(): void;
}
