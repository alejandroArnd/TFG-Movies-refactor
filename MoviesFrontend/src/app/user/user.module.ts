import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UserRoutingModule } from './user-routing.module';
import { RegisterComponent } from './pages/register/register.component';
import { LoginComponent } from './pages/login/login.component';

const COMPONENTS = [RegisterComponent, LoginComponent];

@NgModule({
  declarations: COMPONENTS,
  imports: [
    CommonModule,
    UserRoutingModule
  ]
})
export class UserModule { }
