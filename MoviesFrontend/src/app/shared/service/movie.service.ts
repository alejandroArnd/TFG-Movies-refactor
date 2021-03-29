import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { map } from 'rxjs/operators';
import { MovieCard } from '../interfaces/movie-card.interface';

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
}
