<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ShowTrainingTest;

use Training\Application\Query\ShowTraining\ShowTrainingPresenter;
use Training\Application\Query\ShowTraining\TrainingInformation;

class ShowTrainingTestPresenter implements ShowTrainingPresenter
{
    private TrainingInformation|string $response;

    public function response(): TrainingInformation|string
    {
        return $this->response;
    }

    public function trainingNotFound(): void
    {
        $this->response = 'Training not found';
    }

    public function trainingFound(TrainingInformation $trainingInformation): void
    {
        $this->response = $trainingInformation;
    }
}
