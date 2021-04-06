import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MovieComponent } from './pages/movie/movie.component';
import { MoviesSearchComponent } from './pages/movies-search/movies-search.component';
 
const routes: Routes = [
  { path: 'search', component: MoviesSearchComponent},
  { path: 'movie/:movie', component: MovieComponent},
];
 
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})

export class MoviesRoutingModule {}