import { Genre } from "./genre.interface";

export interface MovieCard{
    id: number;
    title: string;
    accessiblePath: string;
    averageScore: number;
    releaseDate: string;
    genres: Genre[];
}