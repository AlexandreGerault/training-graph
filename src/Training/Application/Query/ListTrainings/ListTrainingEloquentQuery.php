<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

use Training\Infrastructure\Model\TrainingModel;

class ListTrainingEloquentQuery implements ListTrainingsQuery
{
    public function execute(ListTrainingsInput $input): TrainingList
    {
        $paginatedTrainings = TrainingModel::query()
            ->whereUserId($input->userId)
            ->paginate(perPage: $input->perPage, page: $input->page);

        $trainingViewModels = $paginatedTrainings
            ->map(fn(TrainingModel $trainingModel) => new TrainingViewModel(
                $trainingModel->uuid,
                $trainingModel->name,
                $trainingModel->description,
            ))
            ->toArray();

        return new TrainingList(
            trainings: $trainingViewModels,
            currentPage: $paginatedTrainings->currentPage(),
            lastPage: $paginatedTrainings->lastPage(),
            perPage: $paginatedTrainings->perPage(),
        );
    }
}
