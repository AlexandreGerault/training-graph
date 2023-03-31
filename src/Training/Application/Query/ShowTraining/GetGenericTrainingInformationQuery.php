<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Training\Domain\TrainingAggregate\TrainingId;

interface GetGenericTrainingInformationQuery
{
    public function execute(TrainingId $trainingId): TrainingInformation;
}
