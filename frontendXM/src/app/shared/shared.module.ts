import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MainLayoutComponent } from './components/main-layout/main-layout.component';
import {AppRoutingModule} from '../app-routing.module';



@NgModule({
  declarations: [MainLayoutComponent],
  exports: [
  ],
  imports: [
    CommonModule,
    AppRoutingModule
  ]
})
export class SharedModule { }
