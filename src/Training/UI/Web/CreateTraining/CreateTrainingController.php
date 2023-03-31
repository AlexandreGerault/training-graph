<?php

declare(strict_types=1);

namespace Training\UI\Web\CreateTraining;

use Shared\UI\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Command\CreateTraining\CreateTrainingUseCase;

class CreateTrainingController extends Controller
{
    public function __construct(
        private readonly CreateTrainingUseCase $createTraining,
        private readonly CreateTrainingWebPresenter $presenter,
    ) {
    }

    public function __invoke(CreateTrainingRequest $request): Response
    {
        $input = $request->toInput();

        $this->createTraining->execute($input, $this->presenter);

        return $this->presenter->response();
    }
}
