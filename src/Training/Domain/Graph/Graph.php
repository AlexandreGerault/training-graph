<?php

declare(strict_types=1);

namespace Training\Domain\Graph;

class Graph
{
    /** @var Dataset[] */
    private array $datasets = [];

    /**
     * @param GraphType $graphType
     * @param string[] $labels
     */
    public function __construct(
        private readonly GraphType $graphType,
        private readonly array $labels,
    ) {
    }

    public function type(): GraphType
    {
        return $this->graphType;
    }

    public function labelsAsHtmlAttributeValue(): string
    {
        return implode(',', $this->labels);
    }

    /**
     * @param string $datasetName
     * @param array<int|float> $datasetValues
     * @return void
     */
    public function addDataset(string $datasetName, array $datasetValues): void
    {
        $this->datasets[] = new Dataset($datasetName, $datasetValues);
    }

    /**
     * @throws \JsonException
     */
    public function datasetsAsHtmlAttributeValue(): string
    {
        return json_encode($this->datasets, JSON_THROW_ON_ERROR);
    }
}
