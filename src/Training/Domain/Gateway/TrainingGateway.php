<?php

declare(strict_types=1);

namespace Training\Domain\Gateway;

use Training\Domain\TrainingAggregate\Training;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

interface TrainingGateway
{
    public function save(TrainingSnapshot $snapshot): void;

    public function getTrainingById(string $trainingId): Training;
}
