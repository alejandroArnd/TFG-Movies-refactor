import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeaderComponent } from './components/header/header.component';

const CORE_MODULES = [CommonModule];

const COMPONENTS = [HeaderComponent];

@NgModule({
  declarations: COMPONENTS,
  imports: [CORE_MODULES],
  exports: [COMPONENTS, CORE_MODULES],
})
export class SharedModule { }
