<?php

declare(strict_types=1);

namespace Training\Application\Query\ShowTraining;

readonly class GraphData
{
    /**
     * @param string $datasetLabel
     * @param array<array<float>> $values
     * @param array<string> $xAxisLabels
     */
    public function __construct(
        public string $datasetLabel,
        public array $values,
        public array $xAxisLabels,
    ) {
    }

    public function xAxisLabelAsCommaSeparatedList(): string
    {
        return implode(',', $this->xAxisLabels);
    }

    public function valuesAsCommaSeparatedList(): string
    {
        return json_encode($this->values);
    }
}
