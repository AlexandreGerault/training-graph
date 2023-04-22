<?php

namespace Tests\Training\Graph;

use Training\Domain\Graph\Graph;
use Training\Domain\Graph\GraphType;

function create_value_object(int|float $y, int|float $std, int $count): object {
    return (object) [
        'value' => $y,
        'std' => $std,
        'count' => $count,
    ];
}

it("can create a line graph", function () {
    $graph = new Graph(GraphType::Line, ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]);

    expect($graph->type())->toBe(GraphType::Line)
        ->and($graph->labelsAsHtmlAttributeValue())->toBe("Monday,Tuesday,Wednesday,Thursday,Friday");
});

it("can add a dataset to a graph", function (array $datasetValues) {
    $graph = new Graph(GraphType::Line, ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]);

    $graph->addDataset("Hit ratio", $datasetValues);

    expect($graph->datasetsAsHtmlAttributeValue())->toBe('[{"label":"Hit ratio","data":[{"y":0.5,"yMin":0.3187538879391011,"yMax":0.6812461120608989},{"y":0.6,"yMin":0.41875388793910107,"yMax":0.7812461120608989},{"y":0.7,"yMin":0.518753887939101,"yMax":0.8812461120608989},{"y":0.8,"yMin":0.6187538879391011,"yMax":0.981246112060899},{"y":0.9,"yMin":0.7187538879391011,"yMax":1.081246112060899}]}]');
})->with([
    "datasetValues" => [
        [
            create_value_object(0.5, 0.1, 10),
            create_value_object(0.6, 0.1, 10),
            create_value_object(0.7, 0.1, 10),
            create_value_object(0.8, 0.1, 10),
            create_value_object(0.9, 0.1, 10)
        ],
    ],
]);

