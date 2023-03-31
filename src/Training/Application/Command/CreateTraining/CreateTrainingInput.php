<?php

declare(strict_types=1);

namespace Training\Application\Command\CreateTraining;

readonly class CreateTrainingInput
{
    public function __construct(
        public string $gameId,
        public string $userId,
        public string $trainingType,
        public string $name,
        public string $description,
    ) {
    }
}
