<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Training\Domain\TrainingAggregate\TrainingId;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Infrastructure\Model\CsGoAimReflexTrainingViewData;
use Training\Infrastructure\Model\TrainingModel;

class GetEloquentGenericTrainingInformationQuery implements GetGenericTrainingInformationQuery
{
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
            ->selectRaw('AVG(hit_ratio) as hit_ratio, DATE(date) as date')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return new TrainingInformation(
            $training->uuid,
            $training->name,
            $training->description,
            $trainingType->metricColumns(),
            array_map(
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
                array: $training->metricRecords->toArray(),
            ),
            new GraphData(
                'Cibles touchées',
                $graphData->map(
                    static fn (CsGoAimReflexTrainingViewData $data): int => (int) (100 * $data->hit_ratio),
                )->toArray(),
                $graphData->map(
                    static fn (CsGoAimReflexTrainingViewData $data): string => (string) $data->date,
                )->toArray(),
            ),
        );
    }
}
