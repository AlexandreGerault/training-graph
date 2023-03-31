<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

class TrainingList
{
    /**
     * @param array<TrainingViewModel> $trainings
     */
    public function __construct(
        private array $trainings,
        public int $currentPage,
        public int $lastPage,
        public int $perPage,
    ) {
    }

    /** @return array<TrainingViewModel> */
    public function getTrainings(): array
    {
        return $this->trainings;
    }
}
