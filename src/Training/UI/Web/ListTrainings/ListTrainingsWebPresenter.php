<?php

declare(strict_types=1);

namespace Training\UI\Web\ListTrainings;

use Illuminate\Support\ViewErrorBag;
use Illuminate\View\Factory;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Query\ListTrainings\ListTrainingsPresenter;
use Training\Application\Query\ListTrainings\TrainingList;

class ListTrainingsWebPresenter implements ListTrainingsPresenter
{
    private Response $response;

    public function __construct(private Factory $view)
    {
    }

    public function trainingsFetched(TrainingList $trainingList): void
    {
        $view = $this->view->make('training.list', [
            'vm' => $trainingList,
        ]);

        $this->response = new Response($view->render());
    }

    public function failedToFetchTrainings(): void
    {
        $this->response = redirect()->back();

        /** @var ViewErrorBag $errorBag */
        $errorBag = session()->get('errors', new ViewErrorBag());

        $bag = $errorBag->getBag('error');
        $bag->add(key: 'training', message: 'training.list.failed_to_fetch');

        session()->flash('errors', $errorBag->put('default', $bag));
    }

    public function response(): Response
    {
        return $this->response;
    }
}
