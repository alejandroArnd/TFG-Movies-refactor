import { MovieCard } from "./movie-card.interface";

export interface MoviesPaginated{
    moviesSearch: MovieCard[],
    totalItems: number
}