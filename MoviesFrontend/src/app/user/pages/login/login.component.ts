import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { AuthResult } from 'src/app/shared/interfaces/auth-result.interface';
import { UserService } from 'src/app/shared/service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public loginForm: FormGroup;
  public submitted: boolean = false;
  public loginFail: boolean = false

  constructor(private formBuilder: FormBuilder, private userService: UserService) { }

  ngOnInit(): void {
    this.loginForm = this.formBuilder.group({
      username: ['', Validators.required],
      password:['', Validators.required],
  });
  }

  onSubmit(): void {
    this.submitted = true;
    if (this.loginForm.invalid) {
      return;
    }
    this.userService.loginUser(this.loginForm.value).pipe(
      catchError(error => {
        this.loginFail = true;
        return throwError(error);
      }))
      .subscribe(
      (response: AuthResult)=>{
        console.log(response.token);
    })
  }


  get password(){return this.loginForm.get('password');}
  get username(){return this.loginForm.get('username');}
}
