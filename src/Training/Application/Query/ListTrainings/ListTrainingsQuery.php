<?php

declare(strict_types=1);

namespace Training\Application\Query\ListTrainings;

interface ListTrainingsQuery
{
    public function execute(ListTrainingsInput $input): TrainingList;
}
