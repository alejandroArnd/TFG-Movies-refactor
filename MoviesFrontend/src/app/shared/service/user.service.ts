import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';
import { NewUser } from '../interfaces/new-user.interface';
import { UserLogin } from '../interfaces/user-login.interface';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private httpclient: HttpClient ) { }

  public createUser(newUser: NewUser){
    return this.httpclient.post(environment.REST_API_SERVER+environment.REGISTER, newUser);
  }

  public loginUser(user: UserLogin){
    return this.httpclient.post(environment.REST_API_SERVER+environment.LOGIN, user)
  }
}
