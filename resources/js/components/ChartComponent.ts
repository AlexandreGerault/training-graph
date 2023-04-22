import Chart, {ChartType} from 'chart.js/auto';
import {
  LineWithErrorBarsChart,
  LineWithErrorBarsController, PointWithErrorBar
} from "chartjs-chart-error-bars";
import {CategoryScale, LinearScale} from "chart.js";

export class ChartComponent extends HTMLElement {
  private datasetLabel: string;

  private labels: string[];

  private data: number[];

  private type: ChartType;

  connectedCallback() {
    this.labels = this.getAttribute('labels')?.split(',') ?? [];
    this.data = JSON.parse(this.getAttribute('data')).map(value => ({
      y: parseFloat(value.y) * 100,
      yMin: parseFloat(value.yMin) * 100,
      yMax: parseFloat(value.yMax) * 100
    })) ?? [];
    this.datasetLabel = this.getAttribute('dataset-label') ?? '';
    this.type = this.getAttribute('type') as ChartType ?? 'line';
    this.render();
  }

  render() {
    const canvas = document.createElement('canvas');

    this.appendChild(canvas);

    Chart.register(PointWithErrorBar, LineWithErrorBarsChart, LineWithErrorBarsController, LinearScale, CategoryScale);

    new Chart(canvas, {
      type: LineWithErrorBarsController.id,
      data: {
        labels: this.labels,
        datasets: [{
          label: this.datasetLabel,
          data: this.data,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });
  }
}
