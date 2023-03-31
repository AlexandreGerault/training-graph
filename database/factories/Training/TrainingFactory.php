<?php

declare(strict_types=1);

namespace Database\Factories\Training;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Training\Domain\TrainingAggregate\TrainingType;
use Training\Infrastructure\Model\TrainingModel;

/**
 * @extends Factory<TrainingModel>
 */
class TrainingFactory extends Factory
{
    protected $model = TrainingModel::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'user_id' => UserFactory::new(),
            'game_id' => GameFactory::new(),
            'name' => fake()->name(),
            'description' => fake()->text(),
            'training_type' => fake()->randomElement(TrainingType::values()),
        ];
    }
}
