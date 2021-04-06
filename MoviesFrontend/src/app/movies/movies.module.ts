import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { MoviesRoutingModule } from './movies-routing.module';
import { MoviesSearchComponent } from './pages/movies-search/movies-search.component';
import { NgxPaginationModule } from 'ngx-pagination';
import { AdvancedSearchComponent } from './pages/movies-search/advanced-search/advanced-search.component';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { MovieComponent } from './pages/movie/movie.component';
import { MoviesDurationPipe } from './pipes/movies-duration.pipe';

const COMPONENTS = [MoviesSearchComponent, AdvancedSearchComponent, MovieComponent]
const PIPES = [MoviesDurationPipe];

@NgModule({
  declarations: [...COMPONENTS, ...PIPES], 
  imports: [
    SharedModule,
    MoviesRoutingModule,
    NgxPaginationModule,
    ReactiveFormsModule,
    FormsModule,
  ],
  exports: COMPONENTS
})
export class MoviesModule { }
