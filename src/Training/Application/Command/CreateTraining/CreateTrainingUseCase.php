<?php

declare(strict_types=1);

namespace Training\Application\Command\CreateTraining;

use Training\Domain\Gateway\TrainingGateway;
use Training\Domain\TrainingAggregate\GameId;
use Training\Domain\TrainingAggregate\Training;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Domain\TrainingAggregate\UserId;

readonly class CreateTrainingUseCase
{
    public function __construct(private TrainingGateway $trainingGateway)
    {
    }

    public function execute(CreateTrainingInput $input, CreateTrainingPresenter $output): void
    {
        $training = Training::create(
            gameId: GameId::fromString($input->gameId),
            userId: UserId::fromString($input->userId),
            trainingType: TrainingType::from($input->trainingType),
            name: $input->name,
            description: $input->description,
        );

        try {
            $this->trainingGateway->save($training->snapshot());
        } catch (\Exception $e) {
            $output->failedToSaveTraining($training->snapshot());

            return;
        }

        $output->trainingCreated($training->snapshot());
    }
}
