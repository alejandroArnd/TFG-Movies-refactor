import { Component, OnInit } from '@angular/core';
import * as moment from 'moment';

@Component({
  selector: 'movie-footer',
  templateUrl: './footer.component.html',
  styleUrls: ['./footer.component.scss']
})
export class FooterComponent implements OnInit {

  currentYearCopyright: string;
  constructor() { }

  ngOnInit(): void {
    this.currentYearCopyright = moment().format('YYYY');
  }

}
