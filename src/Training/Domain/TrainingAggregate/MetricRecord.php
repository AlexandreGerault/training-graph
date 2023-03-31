<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

use Assert\Assertion;
use Training\Domain\TrainingAggregate\MetricRecords\InvalidMetricRecordDate;
use Traversable;

/**
 * @implements \ArrayAccess<string, string|int>
 * @implements \IteratorAggregate<string, string|int>
 */
abstract class MetricRecord implements \ArrayAccess, \IteratorAggregate
{
    protected \DateTimeInterface $date;

    /**
     * @return iterable<string>
     */
    abstract public static function getMetricNames(): iterable;

    /**
     * @return array<string, string|int>
     */
    abstract public function toArray(): array;

    /**
     * @param array<string, string|int> $values
     */
    abstract public static function fromArray(string $date, array $values): self;

    /**
     * @param array<string, string|int> $values
     */
    abstract protected static function assertValidArray(array $values): void;

    protected static function assertDateIsValid(string $date): void
    {
        try {
            Assertion::date($date, 'Y-m-d');
        } catch (\Exception) {
            throw new InvalidMetricRecordDate($date);
        }
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->toArray());
    }

    public function date(): \DateTimeInterface
    {
        return $this->date;
    }
}
