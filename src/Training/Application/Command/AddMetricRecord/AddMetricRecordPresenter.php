<?php

declare(strict_types=1);

namespace Training\Application\Command\AddMetricRecord;

use Training\Domain\TrainingAggregate\TrainingSnapshot;

interface AddMetricRecordPresenter
{
    public function recordAddedSuccessfully(TrainingSnapshot $training): void;
}
