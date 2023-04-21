<?php

declare(strict_types=1);

namespace Training\Infrastructure\Routes;

use Illuminate\Support\Facades\Route;
use Training\UI\Web\AddMetricRecord\AddMetricRecordController;
use Training\UI\Web\CreateTraining\CreateTrainingController;
use Training\UI\Web\ListTrainings\ListTrainingsWebController;
use Training\UI\Web\ShowTraining\ShowTrainingController;

Route::middleware('auth')->group(function () {
    Route::get(
        uri: 'entrainements',
        action: ListTrainingsWebController::class
    )->name('training.list');

    Route::view(
        uri: 'entrainement/creer',
        view: 'training.create',
    )->name('training.create');

    Route::post(
        uri: 'entrainement/{training}/ajouter-mesure',
        action: AddMetricRecordController::class
    )->name('training.add_metric_record');

    Route::get(
        uri: 'entrainement/{training}',
        action: ShowTrainingController::class,
    )->name('training.show');

    Route::post(
        uri: 'entrainement/creer',
        action: CreateTrainingController::class
    )->name('training.store');
});
