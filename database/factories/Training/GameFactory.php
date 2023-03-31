<?php

declare(strict_types=1);

namespace Database\Factories\Training;

use Illuminate\Database\Eloquent\Factories\Factory;
use Training\Infrastructure\Model\GameModel;

/**
 * @extends Factory<GameModel>
 */
class GameFactory extends Factory
{
    protected $model = GameModel::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->name(),
            'description' => fake()->text(),
        ];
    }
}
