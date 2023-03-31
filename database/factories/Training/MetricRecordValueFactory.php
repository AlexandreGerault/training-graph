<?php

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;
use Training\Infrastructure\Model\MetricRecordValueModel;

/**
 * @extends Factory<MetricRecordValueModel>
 */
class MetricRecordValueFactory extends Factory
{
    protected $model = MetricRecordValueModel::class;

    public function definition(): array
    {
        return [
            'key' => fake()->word,
            'value' => fake()->randomNumber(),
        ];
    }
}
