import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class LocalStorageService {

  constructor() { }

  public saveToken(token: string){
    localStorage.setItem('token', token);
  }

  public deleteToken(){
    localStorage.removeItem('token');
  }
}
