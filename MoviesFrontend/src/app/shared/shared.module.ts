import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { MovieCardComponent } from './components/movie-card/movie-card.component'
import { HttpClientModule } from '@angular/common/http';

const CORE_MODULES = [CommonModule, FormsModule, ReactiveFormsModule, RouterModule, HttpClientModule];

const COMPONENTS = [MovieCardComponent]

@NgModule({
  imports: [CORE_MODULES],
  exports: [CORE_MODULES, COMPONENTS],
  declarations: COMPONENTS,
})
export class SharedModule { }
