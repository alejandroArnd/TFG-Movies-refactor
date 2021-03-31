import { MovieCard } from "./movie-card.interface";

export interface MoviesPaginated{
    moviesSearch: MovieCard[],
    totailItems: number
}