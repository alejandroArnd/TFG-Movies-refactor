import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router'

const CORE_MODULES = [CommonModule, FormsModule, ReactiveFormsModule, RouterModule];

@NgModule({
  imports: [CORE_MODULES],
  exports: [CORE_MODULES],
})
export class SharedModule { }
