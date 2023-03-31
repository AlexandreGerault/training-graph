<?php

declare(strict_types=1);

namespace Training\Application\Command\AddMetricRecord;

use Training\Domain\Gateway\TrainingGateway;
use Training\Domain\TrainingAggregate\MetricRecords\CsGoAimReflexTrainingMetricRecord;
use Training\Domain\TrainingAggregate\MetricRecords\LoLFarmTrainingMetricRecord;
use Training\Domain\TrainingAggregate\TrainingType;

readonly class AddMetricRecordUseCase
{
    public function __construct(private TrainingGateway $trainingGateway)
    {
    }

    public function execute(AddMetricRecordInput $input, AddMetricRecordPresenter $presenter): void
    {
        $training = $this->trainingGateway->getTrainingById($input->trainingId);

        $metricRecord = match ($training->trainingType()) {
            TrainingType::CsGoAimReflexTraining => CsGoAimReflexTrainingMetricRecord::fromArray($input->date, $input->values),
            TrainingType::LoLFarmTraining => LoLFarmTrainingMetricRecord::fromArray($input->date, $input->values),
        };

        $training->addMetricRecord($metricRecord);

        $this->trainingGateway->save($training->snapshot());

        $presenter->recordAddedSuccessfully($training->snapshot());
    }
}
