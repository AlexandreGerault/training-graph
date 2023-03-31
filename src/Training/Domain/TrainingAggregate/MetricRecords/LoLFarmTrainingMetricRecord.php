<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate\MetricRecords;

use Assert\Assertion;
use Training\Domain\TrainingAggregate\MetricRecord;

class LoLFarmTrainingMetricRecord extends MetricRecord
{
    public function __construct(
        protected \DateTimeInterface $date,
        private int $farmCount,
        private int $durationInSeconds,
    ) {
    }

    public static function fromArray(string $date, array $values): self
    {
        self::assertValidArray($values);
        self::assertDateIsValid($date);

        return new self(
            date: new \DateTimeImmutable($date),
            farmCount: $values['farmCount'],
            durationInSeconds: $values['durationInSeconds'],
        );
    }

    protected static function assertValidArray(array $values): void
    {
        try {
            Assertion::keyExists($values, 'farmCount');
            Assertion::integer($values['farmCount']);

            Assertion::keyExists($values, 'durationInSeconds');
            Assertion::integer($values['durationInSeconds']);
        } catch (\Exception) {
            throw new InvalidArrayForMetricRecord($values, self::class);
        }
    }

    public function offsetExists(mixed $offset): bool
    {
        return in_array(
            needle: $offset,
            haystack: (array) $this->getMetricNames(),
            strict: true,
        );
    }

    public function offsetGet(mixed $offset): int
    {
        $exception = new \OutOfBoundsException("Offset $offset does not exist");

        if (! $this->offsetExists($offset)) {
            throw $exception;
        }

        return match ($offset) {
            'farmCount' => $this->farmCount,
            'durationInSeconds' => $this->durationInSeconds,
            default => throw $exception,
        };
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset(mixed $offset): void
    {
        // TODO: Implement offsetUnset() method.
    }

    public static function getMetricNames(): iterable
    {
        yield 'farmCount';
        yield 'durationInSeconds';
    }

    public function toArray(): array
    {
        return [
            'farmCount' => $this->farmCount,
            'durationInSeconds' => $this->durationInSeconds,
        ];
    }
}
