<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

readonly class ListTrainingsInput
{
    public function __construct(
        public string $userId,
        public int $page,
        public int $perPage,
    ) {
    }
}
