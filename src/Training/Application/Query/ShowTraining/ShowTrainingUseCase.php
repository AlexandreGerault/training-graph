<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Training\Domain\TrainingAggregate\TrainingId;

readonly class ShowTrainingUseCase
{
    public function __construct(private GetGenericTrainingInformationQuery $getTrainingInformationQuery)
    {
    }

    public function execute(string $id, ShowTrainingPresenter $presenter): void
    {
        try {
            $trainingInformation = $this->getTrainingInformationQuery->execute(TrainingId::fromString($id));
        } catch (\Exception) {
            $presenter->trainingNotFound();

            return;
        }

        $presenter->trainingFound($trainingInformation);
    }
}
