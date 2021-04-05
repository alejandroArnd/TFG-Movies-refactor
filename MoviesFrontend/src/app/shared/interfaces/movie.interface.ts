import { Genre } from "./genre.interface";

export interface Movie {
    id: number,
    title: string,
    genres: Genre[]
    duration: number,
    overview: string,
    releaseDate: string,
    accessiblePath: string
}
