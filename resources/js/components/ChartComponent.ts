import Chart, {ChartType} from 'chart.js/auto';

export class ChartComponent extends HTMLElement {
  private datasetLabel: string;

  private labels: string[];

  private data: number[];

  private type: ChartType;

  constructor() {
    super();
    console.log('constructor');
  }

  connectedCallback() {
    console.log('connected');
    this.labels = this.getAttribute('labels')?.split(',') ?? [];
    this.data = this.getAttribute('data')?.split(',').map((value) => parseInt(value)) ?? [];
    this.datasetLabel = this.getAttribute('dataset-label') ?? '';
    this.type = this.getAttribute('type') as ChartType ?? 'line';
    this.render();
  }

  render() {
    const canvas = document.createElement('canvas');

    this.appendChild(canvas);

    new Chart(canvas, {
      type: this.type,
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
