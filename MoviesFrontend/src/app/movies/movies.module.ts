import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { MoviesRoutingModule } from './movies-routing.module';
import { MoviesSearchComponent } from './pages/movies-search/movies-search.component';
import { NgxPaginationModule } from 'ngx-pagination';

const COMPONENTS = [MoviesSearchComponent]

@NgModule({
  declarations: COMPONENTS,
  imports: [
    SharedModule,
    MoviesRoutingModule,
    NgxPaginationModule
  ],
  exports: COMPONENTS
})
export class MoviesModule { }
