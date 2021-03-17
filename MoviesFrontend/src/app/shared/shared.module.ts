import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router'
import { HeaderComponent } from './components/header/header.component';
import { FooterComponent } from './components/footer/footer.component';

const CORE_MODULES = [CommonModule, FormsModule, ReactiveFormsModule, RouterModule];

const COMPONENTS = [HeaderComponent, FooterComponent];

@NgModule({
  declarations: COMPONENTS,
  imports: [CORE_MODULES],
  exports: [COMPONENTS, CORE_MODULES],
})
export class SharedModule { }
