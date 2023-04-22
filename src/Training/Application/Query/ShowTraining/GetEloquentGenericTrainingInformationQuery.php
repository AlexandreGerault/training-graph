<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Infrastructure\Model\CsGoAimReflexTrainingViewData;
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

        $graphData = CsGoAimReflexTrainingViewData::query()
            ->addSelect(DB::raw('AVG(hit_ratio) AS hit_ratio'))
            ->addSelect(DB::raw('DATE(date) AS date'))
            ->addSelect(DB::raw('STD(hit_ratio) AS std_hit_ratio'))
            ->addSelect(DB::raw('COUNT(hit_ratio) AS count_hit_ratio'))
            ->whereIn('metric_record_uuid', $training->metricRecords->pluck('uuid'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

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
            graphData: new GraphData(
                datasetLabel: 'Cibles touchées',
                values: $graphData->map(
                    static fn (CsGoAimReflexTrainingViewData $data): array => [
                        'y' => $data->hit_ratio,
                        'yMin' => $data->hit_ratio - $data->std_hit_ratio,
                        'yMax' => $data->hit_ratio + $data->std_hit_ratio,
                    ],
                )->toArray(),
                xAxisLabels: $graphData->map(
                    static fn (CsGoAimReflexTrainingViewData $data): string => (string) $data->date,
                )->toArray(),
            ),
        );
    }
}
