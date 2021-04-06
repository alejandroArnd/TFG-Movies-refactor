import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Movie } from 'src/app/shared/interfaces/movie.interface';
import { MovieService } from 'src/app/shared/service';

@Component({
  selector: 'app-movie',
  templateUrl: './movie.component.html',
  styleUrls: ['./movie.component.scss']
})
export class MovieComponent implements OnInit {

  movie$: Movie;

  constructor(private route: ActivatedRoute, private movieService: MovieService) { }

  ngOnInit(): void {
    const title = this.route.snapshot.params.movie;
    this.movieService.getMovieByTitle(title)
    .subscribe((response: Movie) => {
      this.movie$ = response;
      console.log(response)
    });
  
  }

}
