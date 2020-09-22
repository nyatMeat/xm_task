import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {CompanyInfo} from '../models/companyInfo';

@Injectable({
  providedIn: 'root'
})
export class CompaniesService
{

  constructor(private http: HttpClient)
  {
  }

  getBySymbol(symbol: string)
  {
    return this.http.get<CompanyInfo | null>(`/api/companies/${symbol}`);
  }

  getList()
  {
    return this.http.get<CompanyInfo[]>(`/api/companies`);
  }
}
