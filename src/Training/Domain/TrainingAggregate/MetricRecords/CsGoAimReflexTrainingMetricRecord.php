<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate\MetricRecords;

use Assert\Assertion;
use Training\Domain\TrainingAggregate\MetricRecord;

class CsGoAimReflexTrainingMetricRecord extends MetricRecord
{
    public function __construct(
        protected \DateTimeInterface $date,
        private int $targetCount,
        private int $hitCount,
        private int $missCount,
    ) {
    }

    public static function fromArray(string $date, array $values): self
    {
        self::assertValidArray($values);
        self::assertDateIsValid($date);

        return new self(
            date: new \DateTimeImmutable($date),
            targetCount: $values['targetCount'],
            hitCount: $values['hitCount'],
            missCount: $values['missCount'],
        );
    }

    protected static function assertValidArray(array $values): void
    {
        try {
            Assertion::keyExists($values, 'targetCount');
            Assertion::integer($values['targetCount']);

            Assertion::keyExists($values, 'hitCount');
            Assertion::integer($values['hitCount']);

            Assertion::keyExists($values, 'missCount');
            Assertion::integer($values['missCount']);
        } catch (\Exception) {
            throw new InvalidArrayForMetricRecord($values, self::class);
        }
    }

    public function toArray(): array
    {
        return [
            'targetCount' => $this->targetCount,
            'hitCount' => $this->hitCount,
            'missCount' => $this->missCount,
        ];
    }

    public static function getMetricNames(): iterable
    {
        yield 'date';
        yield 'target_count';
        yield 'hit_count';
        yield 'miss_count';
    }

    public function offsetExists(mixed $offset): bool
    {
        return in_array(
            needle: $offset,
            haystack: (array) self::getMetricNames(),
            strict: true
        );
    }

    public function offsetGet(mixed $offset): int
    {
        return match ($offset) {
            'targetCount' => $this->targetCount,
            'hitCount' => $this->hitCount,
            'missCount' => $this->missCount,
            default => throw new \OutOfBoundsException("Offset $offset does not exist"),
        };
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
    }

    public function offsetUnset(mixed $offset): void
    {
    }
}
