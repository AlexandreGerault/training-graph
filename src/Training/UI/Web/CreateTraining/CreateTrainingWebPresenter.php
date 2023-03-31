<?php

declare(strict_types=1);

namespace Training\UI\Web\CreateTraining;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ViewErrorBag;
use Training\Application\Command\CreateTraining\CreateTrainingPresenter;
use Training\Domain\TrainingAggregate\TrainingSnapshot;

class CreateTrainingWebPresenter implements CreateTrainingPresenter
{
    private RedirectResponse $response;

    public function __construct()
    {
    }

    public function trainingCreated(TrainingSnapshot $training): void
    {
        $this->response = redirect()->route('training.show', ['training' => $training->id->get()]);
    }

    public function failedToSaveTraining(TrainingSnapshot $training): void
    {
        $this->response = new RedirectResponse(route('training.create'));

        /** @var ViewErrorBag $errorBag */
        $errorBag = session()->get('errors', new ViewErrorBag());

        $bag = $errorBag->getBag('error');
        $bag->add(key: 'training', message: 'training.create.failed_to_save');

        session()->flash('errors', $errorBag->put('default', $bag));
    }

    public function response(): RedirectResponse
    {
        return $this->response;
    }
}
