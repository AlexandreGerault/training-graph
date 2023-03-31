<?php

declare(strict_types=1);

namespace Tests\Training\Feature\AddMetricRecord;

use Training\Application\Command\AddMetricRecord\AddMetricRecordPresenter;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

class AddMetricRecordTestPresenter implements AddMetricRecordPresenter
{
    public TrainingSnapshot $training;

    public function __construct()
    {
    }

    public function recordAddedSuccessfully(TrainingSnapshot $training): void
    {
        $this->training = $training;
    }
}
