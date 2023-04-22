<div id="myChart">
    <chart-component labels="{{ $chartData->labelsAsHtmlAttributeValue() }}"
                     datasets="{{ $chartData->datasetsAsHtmlAttributeValue() }}"></chart-component>
</div>
