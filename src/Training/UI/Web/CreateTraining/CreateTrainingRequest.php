<?php

declare(strict_types=1);

namespace Training\UI\Web\CreateTraining;

use Illuminate\Foundation\Http\FormRequest;
use Training\Application\Command\CreateTraining\CreateTrainingInput;
use Training\Infrastructure\Model\GameModel;

class CreateTrainingRequest extends FormRequest
{
    /**
     * @return array<array-key, string[]>
     */
    public function rules(): array
    {
        return [];
    }

    public function toInput(): CreateTrainingInput
    {
        return new CreateTrainingInput(
            gameId: GameModel::firstOrCreate()->uuid,
            userId: $this->user()->uuid,
            trainingType: $this->string('trainingType')->toString(),
            name: $this->string('name')->toString(),
            description: $this->string('description')->toString(),
        );
    }
}
