<?php

namespace Tests\Training\Graph;

use Training\Domain\Graph\Graph;
use Training\Domain\Graph\GraphType;

it("can create a line graph", function () {
    $graph = new Graph(GraphType::Line, ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]);

    expect($graph->type())->toBe(GraphType::Line)
        ->and($graph->labelsAsHtmlAttributeValue())->toBe("Monday,Tuesday,Wednesday,Thursday,Friday");
});

it("can add a dataset to a graph", function () {
    $graph = new Graph(GraphType::Line, ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"]);

    $graph->addDataset("Hit ratio", [0.5, 0.6, 0.7, 0.8, 0.9]);

    expect($graph->datasetsAsHtmlAttributeValue())->toBe("[{\"label\":\"Hit ratio\",\"data\":[0.5,0.6,0.7,0.8,0.9]}]");
});

