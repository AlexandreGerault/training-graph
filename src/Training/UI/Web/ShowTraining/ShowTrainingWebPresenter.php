<?php

declare(strict_types=1);

namespace Training\UI\Web\ShowTraining;

use Illuminate\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Query\ShowTraining\ShowTrainingPresenter;
use Training\Application\Query\ShowTraining\TrainingInformation;

class ShowTrainingWebPresenter implements ShowTrainingPresenter
{
    private Response $response;

    public function __construct(private Factory $view)
    {
    }

    public function trainingFound(TrainingInformation $trainingInformation): void
    {
        $view = $this->view->make('training.show', [
            'vm' => $trainingInformation,
        ]);

        $this->response = new Response($view->render());
    }

    public function trainingNotFound(): void
    {
        abort(404, 'Training not found');
    }

    public function response(): Response
    {
        return $this->response;
    }
}
