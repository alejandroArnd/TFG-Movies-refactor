import { NgModule } from '@angular/core';
import { HomeComponent } from './pages/home/home.component';
import { HomeRoutingModule } from './home-routing.module';
import { SharedModule } from '../shared/shared.module';

const COMPONENTS = [HomeComponent]

@NgModule({
  declarations: COMPONENTS,
  imports: [
    HomeRoutingModule,
    SharedModule
  ],
  exports: COMPONENTS
})
export class HomeModule { }
