<?php

declare(strict_types=1);

namespace Training\UI\Web\AddMetricRecord;

use Shared\UI\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Training\Application\Command\AddMetricRecord\AddMetricRecordUseCase;

class AddMetricRecordController extends Controller
{
    public function __construct(
        private readonly AddMetricRecordUseCase $addMetricRecord,
        private readonly AddMetricRecordWebPresenter $presenter,
    ) {
    }

    public function __invoke(AddMetricRecordRequest $request): Response
    {
        $this->addMetricRecord->execute($request->toInput(), $this->presenter);

        return $this->presenter->response();
    }
}
