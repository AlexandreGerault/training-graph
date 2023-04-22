import Chart, {ChartDataset, ChartType} from 'chart.js/auto';
import {
  LineWithErrorBarsChart,
  LineWithErrorBarsController, PointWithErrorBar
} from "chartjs-chart-error-bars";
import {CategoryScale, LinearScale} from "chart.js";

export class ChartComponent extends HTMLElement {
  private datasets: ChartDataset[];

  private labels: string[];

  private data: number[];

  private type: ChartType;

  connectedCallback() {
    this.labels = this.getAttribute('labels')?.split(',') ?? [];
    this.datasets = JSON.parse(this.getAttribute('datasets')) ?? [];
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
        datasets: this.datasets,
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
