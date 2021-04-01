import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MoviesSearchComponent } from './pages/movies-search/movies-search.component';
 
const routes: Routes = [
  { path: 'search', component: MoviesSearchComponent},
];
 
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})

export class MoviesRoutingModule {}