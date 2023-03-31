<?php

declare(strict_types=1);

namespace Training\UI\Web\ShowTraining;

use Shared\UI\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Query\ShowTraining\ShowTrainingUseCase;

class ShowTrainingController extends Controller
{
    public function __construct(
        private readonly ShowTrainingUseCase $useCase,
        private readonly ShowTrainingWebPresenter $presenter
    ) {
    }

    public function __invoke(string $id): Response
    {
        $this->useCase->execute($id, $this->presenter);

        return $this->presenter->response();
    }
}
