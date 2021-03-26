import { Component, Input, OnInit } from '@angular/core';
import { MovieCard } from '../../interfaces/movie-card.interface';

@Component({
  selector: 'movie-card',
  templateUrl: './movie-card.component.html',
  styleUrls: ['./movie-card.component.scss']
})
export class MovieCardComponent implements OnInit {

  @Input() movie: MovieCard;

  constructor() { }

  ngOnInit(): void {
  }

}
