<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

readonly class ListTrainingsUseCase
{
    public function __construct(private ListTrainingsQuery $query)
    {
    }

    public function execute(ListTrainingsInput $input, ListTrainingsPresenter $presenter): void
    {
        try {
            $trainingList = $this->query->execute($input);
        } catch (\Exception) {
            $presenter->failedToFetchTrainings();

            return;
        }

        $presenter->trainingsFetched($trainingList);
    }
}
