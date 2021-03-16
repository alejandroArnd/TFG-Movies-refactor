import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'movie-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  dropdown = true
  constructor() { }

  ngOnInit(): void {
  }

}
