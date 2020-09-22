import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {GetHistoryRequest} from '../models/getHistoryRequest';
import {HistoricalItem} from '../models/historicalItem';

@Injectable({
  providedIn: 'root'
})
export class FinancialService
{

  constructor(private http: HttpClient)
  {
  }

  getHistoryRequest(requestData: GetHistoryRequest)
  {
    return this.http.post<HistoricalItem[]>('/api/financial-info/for-period', requestData);
  }

}
