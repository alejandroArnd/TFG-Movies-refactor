import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HomeComponent } from './pages/home/home.component';
import { HomeRoutingModule } from './home-routing.module';
import { SharedModule } from '../shared/shared.module';

const COMPONENTS = [HomeComponent]

@NgModule({
  declarations: COMPONENTS,
  imports: [
    CommonModule,
    HomeRoutingModule,
    SharedModule
  ],
  exports: COMPONENTS
})
export class HomeModule { }
