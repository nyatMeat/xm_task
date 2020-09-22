import {Component, OnInit} from '@angular/core';
import {FormControl, FormGroup, Validators} from '@angular/forms';
import {FinancialService} from '../shared/services/financial.service';
import {GetHistoryRequest} from '../shared/models/getHistoryRequest';
import {HistoricalItem} from '../shared/models/historicalItem';
import {formatDate} from '@angular/common';
import {CompaniesService} from '../shared/services/companies.service';
import {NgbDate, NgbDateParserFormatter} from '@ng-bootstrap/ng-bootstrap';

@Component({
  selector: 'app-home-page',
  templateUrl: './home-page.component.html',
  styleUrls: ['./home-page.component.scss']
})
export class HomePageComponent implements OnInit
{
  form: FormGroup;
  now: Date = new Date();
  loading = false;
  historyItems: HistoricalItem[] = [];
  maxDate = {year: this.now.getFullYear(), month: this.now.getMonth() + 1, day: this.now.getDate()};

  constructor(
    private financialService: FinancialService,
    private companyService: CompaniesService,
    private dateFormatter: NgbDateParserFormatter
  )
  {
  }

  ngOnInit()
  {

    this.form = new FormGroup({
      email: new FormControl(null, [
        Validators.required,
        Validators.email
      ]),
      dateFrom: new FormControl(null, [
        Validators.required
      ]),
      dateTo: new FormControl(null, [
        Validators.required
      ]),
      companySymbol: new FormControl(null, [
        Validators.required
      ])
    });
  }

  submit()
  {
    if (this.form.invalid)
    {
      return;
    }
    this.historyItems = [];
    const companySymbol = this.form.value.companySymbol;
    const dateFromString = this.ngbDateToString(this.form.get('dateFrom').value);
    const dateToString = this.ngbDateToString(this.form.get('dateTo').value);
    if (dateToString > formatDate(this.now, 'yyyy-MM-dd', 'en'))
    {
      this.form.get('dateTo').setErrors({
        dateHigherThanNow: true
      });
      return;
    }

    if (dateFromString > formatDate(this.now, 'yyyy-MM-dd', 'en'))
    {
      this.form.get('dateFrom').setErrors({
        dateHigherThanNow: true
      });
      return;
    }
    if (dateFromString > dateToString)
    {
      this.form.get('dateFrom').setErrors({
        dateFromHigherThanDateTo: true
      });
      return;
    }

    this.loading = true;
    this.companyService.getBySymbol(companySymbol).subscribe(
      result =>
      {
        if (!result)
        {
          this.loading = false;
          this.form.get('companySymbol').setErrors({
            companyIsNotExists: true
          });
        } else
        {
          const historyRequest: GetHistoryRequest = {
            companySymbol: this.form.value.companySymbol,
            dateFrom: dateFromString,
            dateTo: dateToString,
            email: this.form.value.email
          };
          this.financialService.getHistoryRequest(historyRequest).subscribe((data: HistoricalItem[]) =>
            {
              this.loading = false;
              this.historyItems = data;

            },
            error =>
            {
              this.loading = false;
            });
        }
      },
      error1 =>
      {
        this.loading = false;
      }
    );
  }


  ngbDateToString(ngb: NgbDate)
  {
    return this.dateFormatter.format(ngb);
  }

}
