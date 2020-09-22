import {Component, Input, OnChanges, OnInit} from '@angular/core';
import {HistoricalItem} from '../shared/models/historicalItem';

@Component({
  selector: 'app-history-table',
  templateUrl: './history-table.component.html',
  styleUrls: ['./history-table.component.scss']
})
export class HistoryTableComponent implements OnInit
{

  @Input() historyItems: HistoricalItem[] = [];
  @Input() loading = false;

  constructor()
  {
  }

  ngOnInit(): void
  {
  }
}
