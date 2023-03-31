<?php

declare(strict_types=1);

namespace Training\UI\Web\AddMetricRecord;

use Symfony\Component\HttpFoundation\Response;
use Training\Application\Command\AddMetricRecord\AddMetricRecordPresenter;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

class AddMetricRecordWebPresenter implements AddMetricRecordPresenter
{
    private Response $response;

    public function recordAddedSuccessfully(TrainingSnapshot $training): void
    {
        $this->response = redirect()->route('training.show', ['training' => $training->id->get()]);
    }

    public function response(): Response
    {
        return $this->response;
    }
}
