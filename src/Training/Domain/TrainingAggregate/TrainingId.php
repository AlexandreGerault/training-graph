<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

use Symfony\Component\Uid\Uuid;

class TrainingId
{
    private function __construct(
        private string $id = '',
    ) {
    }

    public static function generate(): TrainingId
    {
        return new self(
            id: Uuid::v4()->toRfc4122(),
        );
    }

    public static function fromString(string $id): TrainingId
    {
        return new self(
            id: $id,
        );
    }

    public function get(): string
    {
        return $this->id;
    }
}
