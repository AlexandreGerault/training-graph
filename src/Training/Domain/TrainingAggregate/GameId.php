<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

class GameId
{
    public function __construct(
        private string $id,
    ) {
    }

    public static function fromString(string $id): self
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
