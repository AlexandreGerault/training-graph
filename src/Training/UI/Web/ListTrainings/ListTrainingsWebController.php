<?php

declare(strict_types=1);

namespace Training\UI\Web\ListTrainings;

use Illuminate\Http\Request;
use Shared\UI\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Query\ListTrainings\ListTrainingsInput;
use Training\Application\Query\ListTrainings\ListTrainingsUseCase;

class ListTrainingsWebController extends Controller
{
    public function __construct(
        private readonly ListTrainingsUseCase $useCase,
        private readonly ListTrainingsWebPresenter $presenter,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $input = new ListTrainingsInput(
            userId: $request->user()->uuid,
            page: $request->integer('page', 1),
            perPage: $request->integer('limit', 10),
        );

        $this->useCase->execute($input, $this->presenter);

        return $this->presenter->response();
    }
}
