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
     * @param array{value: int|float, std: int|float, count: int} $datasetValues
     * @param callable|null $transformValueCallback (object $value) => Value
     * @return void
     */
    public function addDataset(
        string $datasetName,
        array $datasetValues,
        ?callable $transformValueCallback = null,
        string $valueKey = 'value',
        string $stdKey = 'std',
        string $countKey = 'count',
    ): void {
        if ($transformValueCallback === null) {
            $transformValueCallback = static fn (object $value) => new Value(
                (float) $value->$valueKey,
                (float) $value->$stdKey,
                (int) $value->$countKey
            );
        }

        $datasetValues = array_map(
            $transformValueCallback,
            $datasetValues,
        );

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
