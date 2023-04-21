<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;
use Training\Infrastructure\Model\MetricRecordModel;

/**
 * @extends Factory<MetricRecordModel>
 */
class MetricRecordFactory extends Factory
{
    protected $model = MetricRecordModel::class;

    public function definition(): array
    {
        return [
            'date' => fake()->date(),
        ];
    }
}
