<?php

declare(strict_types=1);

namespace Tests\Training\Feature\ShowTrainingTest;

use Training\Application\Query\ShowTraining\GetGenericTrainingInformationQuery;
use Training\Application\Query\ShowTraining\GraphData;
use Training\Application\Query\ShowTraining\TrainingInformation;
use Training\Domain\TrainingAggregate\TrainingId;

class GetGenericTrainingInformationQueryDumb implements GetGenericTrainingInformationQuery
{
    public function __construct(private bool $notFound = false)
    {
    }

    public function execute(TrainingId $trainingId): TrainingInformation
    {
        if ($this->notFound) {
            throw new \Exception('Training not found');
        }

        return new TrainingInformation(
            $trainingId->get(),
            'Training name',
            'Training description',
            [],
            [],
            new GraphData('Aim Reflex', [], []),
        );
    }
}
