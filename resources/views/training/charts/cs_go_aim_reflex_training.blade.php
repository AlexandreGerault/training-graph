<div id="myChart">
    <chart-component labels="{{ $chartData->xAxisLabelAsCommaSeparatedList() }}"
                     data="{{ $chartData->valuesAsCommaSeparatedList() }}"
                     dataset-label="{{ $chartData->datasetLabel }}"></chart-component>
</div>
