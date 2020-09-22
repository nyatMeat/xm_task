import {Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';
import {HistoricalItem} from '../shared/models/historicalItem';
import {formatDate} from '@angular/common';

@Component({
  selector: 'app-history-chart',
  templateUrl: './history-chart.component.html',
  styleUrls: ['./history-chart.component.scss']
})
export class HistoryChartComponent implements OnInit, OnChanges
{

  @Input() historyItems: HistoricalItem[] = [];
  @Input() loading = false;

  chartOptions: any;

  constructor()
  {
  }

  ngOnInit(): void
  {
  }

  ngOnChanges(changes: SimpleChanges): void
  {
    if (!this.loading && this.historyItems.length)
    {
      this.initChart(this.historyItems);
    }
  }

  initChart(items: HistoricalItem[])
  {
    items = items.slice().reverse();
    const xAxisData = [];
    const open = [];
    const close = [];
    items.forEach((value) =>
    {
      xAxisData.push(formatDate(new Date(value.date * 1000), 'yyyy-MM-dd', 'en'));
      open.push(value.open);
      close.push(value.close);
    });

    this.chartOptions = {
      legend: {
        data: ['open', 'close'],
        align: 'left',
      },
      tooltip: {},
      xAxis: {
        data: xAxisData,
        silent: false,
        splitLine: {
          show: false,
        },
      },
      yAxis: {},
      series: [
        {
          name: 'Open',
          type: 'bar',
          data: open,
          animationDelay: (idx) => idx * 10,
        },
        {
          name: 'Close',
          type: 'bar',
          data: close,
          animationDelay: (idx) => idx * 10 + 100,
        },
      ],
      animationEasing: 'elasticOut'
    };
  }
}
