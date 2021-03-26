import { Genre } from "./genre.interface";

export interface MovieCard{
    id: number;
    title: string;
    accessiblePath: string;
    avarageScore: number;
    releaseDate: string;
    genres: Genre[];
}