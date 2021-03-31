import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { map } from 'rxjs/operators';
import { MovieCard } from '../interfaces/movie-card.interface';
import { MoviesPaginated } from '../interfaces/movies-paginated.interface';

@Injectable({
  providedIn: 'root'
})
export class MovieService {

  constructor(private httpClient: HttpClient) {}

  public getTopRatedMovies(): Observable<MovieCard[]>{
    return this.httpClient
      .get<MovieCard[]>(environment.REST_API_SERVER + environment.TOP_RATED_MOVIES);
  }

  public getComingSoonMovies(): Observable<MovieCard[]>{
    return this.httpClient
      .get<MovieCard[]>(environment.REST_API_SERVER + environment.COMING_SOON_MOVIES);
  }

  public getMostPopularMovies(): Observable<MovieCard[]>{
    return this.httpClient
      .get<MovieCard[]>(environment.REST_API_SERVER + environment.MOST_POPULAR_MOVIES);
  }

  public getMoviesByUrlQueryParams(queryParams:{ [param: string]: string | string[]; }): Observable<MoviesPaginated>{
    let params = new HttpParams().appendAll(queryParams)
    if(!params.has('title')){
      params = params.append('title', "");
    }
    return this.httpClient
      .get<MoviesPaginated>(environment.REST_API_SERVER + environment.SEARCH_MOVIES, { params: params });
  }
}
