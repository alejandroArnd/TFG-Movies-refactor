<?php

namespace App\Application\UseCases\Movies;

use DateTime;
use App\Domain\Model\MoviesModel;
use App\Application\Repository\GenreRepository;
use App\Application\Repository\MoviesRepository;
use App\Domain\Exception\GenreNotFoundException;
use App\Application\Service\ManageUploadFileService;
use App\Domain\Exception\MovieAlreadyExistException;

class CreateMovie
{
    private MoviesRepository $moviesRepository;
    private GenreRepository $genreRepository;
    private ManageUploadFileService $manageUploadFileService;
    private string $pathToUpload;

    public function __construct(MoviesRepository $moviesRepository, GenreRepository $genreRepository, ManageUploadFileService $manageUploadFileService)
    {
        $this->moviesRepository = $moviesRepository;
        $this->genreRepository = $genreRepository;
        $this->manageUploadFileService = $manageUploadFileService;
        $this->pathToUpload = "/var/www/html/uploadMovieImages/";
    }

    public function handle($movie): void
    {
        $movieAlreadyExit = $this->moviesRepository->findOneByTitle($movie->title);

        if($movieAlreadyExit){
            throw new MovieAlreadyExistException();
        }

        $genres = [];

        $newMovie = new MoviesModel($movie->title, $movie->overview, new DateTime($movie->releaseDate), $movie->duration);

        foreach($movie->genres as $genre){
            $genreFound = $this->genreRepository->findOneByName($genre);
            
            if(!$genreFound){
                throw new GenreNotFoundException($genre);
            }

            $newMovie->addGenre($genreFound);
        }

        $accessiblePath = $this->manageUploadFileService->uploadFileFromBase64($this->pathToUpload, $movie);
        $newMovie->setAccessiblePath($accessiblePath);
        $this->moviesRepository->save($newMovie);
    }
}