import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MovieCard } from 'src/app/shared/interfaces/movie-card.interface';
import { MoviesPaginated } from 'src/app/shared/interfaces/movies-paginated.interface';
import { MovieService } from 'src/app/shared/service';

@Component({
  selector: 'movies-search',
  templateUrl: './movies-search.component.html',
  styleUrls: ['./movies-search.component.scss']
})
export class MoviesSearchComponent implements OnInit {

  movies$: MovieCard[] = [];
  moviesLoading: boolean = true;
  totalItems: number;
  currentPage: number;

  constructor(private route: ActivatedRoute, private movieService: MovieService, private router: Router) { }

  ngOnInit(): void {
    this.route.queryParams.subscribe(params => {
      if(!Object.keys(params).length){
        params = {title: "", page: 1}
      }
      this.currentPage = params.page;
      this.moviesLoading = true;
      this.movieService.getMoviesByUrlQueryParams(params)
      .subscribe((response: MoviesPaginated) => {
        this.movies$ = [];
        this.movies$ = response.moviesSearch;
        this.moviesLoading = false;
        this.totalItems = response.totalItems;
      });
  });
  }

  pageChange(newPage: number) {
    const queryParams = {...this.route.snapshot.queryParams};
    queryParams.page = newPage;
    this.router.navigate(['/search'], { queryParams: queryParams });
  }

}
