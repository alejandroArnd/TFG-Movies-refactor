import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';


import { FormControl } from '@angular/forms';

@Component({
  selector: 'movie-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent {

  titleToSearchMovie = new FormControl();

  constructor( private router: Router) { }

  onSearchMovie(): void{
    this.router.navigate(['/search'], {queryParams:this.titleToSearchMovie.value}); 
  }

}
