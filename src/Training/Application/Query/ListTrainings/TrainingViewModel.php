<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

class TrainingViewModel
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $description,
    ) {
    }
}
