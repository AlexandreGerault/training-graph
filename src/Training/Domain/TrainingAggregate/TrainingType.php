<?php

declare(strict_types=1);

namespace Training\Domain\TrainingAggregate;

use Training\Domain\TrainingAggregate\MetricRecords\CsGoAimReflexTrainingMetricRecord;
use Training\Domain\TrainingAggregate\MetricRecords\LoLFarmTrainingMetricRecord;

enum TrainingType: string
{
    case CsGoAimReflexTraining = 'cs_go_aim_reflex_training';
    case LoLFarmTraining = 'lol_farm_training';

    /**
     * @param  array<array-key, int>  $values
     */
    public function createMetricRecord(string $date, array $values): MetricRecord
    {
        return match ($this) {
            self::CsGoAimReflexTraining => CsGoAimReflexTrainingMetricRecord::fromArray($date, $values),
            self::LoLFarmTraining => LoLFarmTrainingMetricRecord::fromArray($date, $values),
        };
    }

    /**
     * @return array<array-key, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (\BackedEnum $case): string => $case->value,
            array_values(self::cases()),
        );
    }

    /**
     * @return iterable<string>
     */
    public function metricColumns(): iterable
    {
        return match ($this) {
            self::CsGoAimReflexTraining => CsGoAimReflexTrainingMetricRecord::getMetricNames(),
            self::LoLFarmTraining => LoLFarmTrainingMetricRecord::getMetricNames(),
        };
    }
}
