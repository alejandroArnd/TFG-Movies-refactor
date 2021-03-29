import { Component, OnInit } from '@angular/core';
import { MovieService } from '../../../shared/service'
import { MovieCard } from '../../../shared/interfaces/movie-card.interface';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss']
})
export class HomeComponent implements OnInit {

  moviesTopRated$: MovieCard[];
  moviesComingSoon$: MovieCard[];
  moviesMostPopular$: MovieCard[];

  constructor(private movieService: MovieService) { }

  ngOnInit(): void {
    this.movieService.getTopRatedMovies()
      .subscribe((response: MovieCard[]) => {
        this.moviesTopRated$ = response;
      });
    
    this.movieService.getComingSoonMovies()
      .subscribe((response: MovieCard[]) => {
        this.moviesComingSoon$ = response;
      });

    this.movieService.getMostPopularMovies()
      .subscribe((response: MovieCard[]) => {
        this.moviesMostPopular$ = response;
      });
  }

}
