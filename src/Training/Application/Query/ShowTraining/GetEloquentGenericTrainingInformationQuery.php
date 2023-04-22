<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Training\Domain\Graph\Graph;
use Training\Domain\Graph\GraphType;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Infrastructure\Model\TrainingModel;

class GetEloquentGenericTrainingInformationQuery implements GetGenericTrainingInformationQuery
{
    private const NUMBER_OF_RECORDS = 5;

    public function execute(TrainingId $trainingId): TrainingInformation
    {
        $training = TrainingModel::query()
            ->where('uuid', '=', $trainingId->get())
            ->with(['metricRecords.values'])
            ->first();

        if (is_null($training)) {
            throw new \Exception('Training not found');
        }

        $trainingType = TrainingType::from($training->training_type);

        $trainingRecordIds = implode(
            separator: ',',
            array: $training->metricRecords
                ->pluck('uuid')
                ->map(static fn ($uuid) => "'$uuid'")
                ->toArray()
        );

        $result = DB::select(<<<SQL
WITH RECURSIVE dates_without_gaps(day) AS (
  SELECT DATE_SUB(CURRENT_DATE, INTERVAL 14 DAY) as day
  UNION ALL
  SELECT DATE_ADD(day, INTERVAL 1 DAY) as day
  FROM dates_without_gaps
  WHERE day < CURRENT_DATE
)
SELECT
    dates_without_gaps.day,
    100 * COALESCE(AVG(cs_go_aim_reflex_training_view.hit_ratio), 0.0) as hit_ratio,
    100 * COALESCE(STD(cs_go_aim_reflex_training_view.hit_ratio), 0.0) as std_hit_ratio,
    COALESCE(COUNT(cs_go_aim_reflex_training_view.hit_ratio), 0.0) as count_hit_ratio
FROM
    dates_without_gaps
LEFT JOIN
    cs_go_aim_reflex_training_view ON (cs_go_aim_reflex_training_view.date = dates_without_gaps.day)
WHERE
    cs_go_aim_reflex_training_view.metric_record_uuid IN ($trainingRecordIds)
OR
    cs_go_aim_reflex_training_view.metric_record_uuid IS NULL
GROUP BY dates_without_gaps.day;
SQL);

        $period = CarbonPeriod::create(Carbon::now()->subDays(14), Carbon::now());
        $generator = $period->map(static fn ($date) => $date->format('Y-m-d'));
        $graph = new Graph(GraphType::Line, iterator_to_array($generator));
        $graph->addDataset(
            datasetName: "Cibles touchées",
            datasetValues: $result,
            valueKey: 'hit_ratio',
            stdKey: 'std_hit_ratio',
            countKey: 'count_hit_ratio'
        );

        return new TrainingInformation(
            uuid: $training->uuid,
            name: $training->name,
            description: $training->description,
            metricColumns: $trainingType->metricColumns(),
            metricRecords: array_map(
                static function (array $metricRecord) use ($trainingType) {
                    $values = collect($metricRecord['values'])
                        ->mapWithKeys(
                            static function (array $value) {
                                return [$value['key'] => $value['value']];
                            },
                        )->toArray();

                    return $trainingType->createMetricRecord(
                        Carbon::create($metricRecord['date'])->format('Y-m-d'),
                        $values
                    );
                },
                array: $training->metricRecords->take(self::NUMBER_OF_RECORDS)->toArray(),
            ),
            graph: $graph,
        );
    }
}
