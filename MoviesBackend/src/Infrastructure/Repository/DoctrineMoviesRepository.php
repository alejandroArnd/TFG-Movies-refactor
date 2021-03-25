<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\MoviesModel;
use App\Infrastructure\Entity\Movies;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Mapper\MovieMapper;
use App\Application\Repository\MoviesRepository;
use App\Infrastrcture\Service\QueryBuilderMovie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineMoviesRepository extends ServiceEntityRepository implements MoviesRepository
{
    private MovieMapper $movieMapper;
    public function __construct(ManagerRegistry $registry, MovieMapper $movieMapper)
    {
        parent::__construct($registry, Movies::class);
        $this->movieMapper = $movieMapper;
    }

    public function getAll(): array
    {
        return $this->movieMapper->toArrayModel($this->findAll());
    }

    public function save(MoviesModel $movie):void
    {
        $movieToSave = $movie->getId() ? $this->update($movie) : $this->movieMapper->toEntity($movie);
        $this->getEntityManager()->persist($movieToSave);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?MoviesModel
    {
        $movie = $this->find($id);
        return (!$movie) ? $movie : $this->movieMapper->toModel($movie);
    }

    public function findOneByTitle(string $title): ?MoviesModel
    {
        $movie = $this->findOneBy(['title' => $title]);
        return (!$movie) ? $movie : $this->movieMapper->toModel($movie);
    }

    public function findMoviesBySeveralCriterias(object $criteriaParams): object
    {
        $queryBuilderMovie = new QueryBuilderMovie();
        [$movies, $totalItems] = $queryBuilderMovie->createQueryBuilderMovie($this)
            ->addSearchByTitle($criteriaParams->title)
            ->addSearchByGenres($criteriaParams)
            ->getPaginateResultQuery(2,$criteriaParams->page);
        $searchResponse = (object) ['movies' => $this->movieMapper->toArrayModel($movies), 'totalItems' => $totalItems];
        return $searchResponse;
    }

    public function findTopRatedMovies(): array
    {
        $queryBuilderMovie = new QueryBuilderMovie();
        $movies = $queryBuilderMovie->createQueryBuilderMovie($this)
            ->addSelectAvgScoreMovie()
            ->orderMoviesBy($queryBuilderMovie->getExprQuery()->avg('review.score'))
            ->setMaxResultsQuery(10)
            ->getResultOfQuery();

        $moviesModel=[];

        foreach($movies as $movie){
            $moviesModel[] = (object)['movie' => $this->movieMapper->toModel($movie[0]), 'averageScore' => round($movie[1],1)];
        }
        return $moviesModel;

    }

    private function update($movieModel)
    {
        $movieFound = $this->find($movieModel->getId());
        $movieFound->setTitle($movieModel->getTitle());
        $movieFound->setOverview($movieModel->getOverview());
        $movieFound->setReleaseDate($movieModel->getReleaseDate());
        $movieFound->setDuration($movieModel->getDuration());
        $movieFound->setIsDeleted($movieModel->getIsDeleted());

        $genreEntities = $this->movieMapper->toArrayEntityGenre($movieModel->getGenres());

        foreach($movieFound->getGenres() as $genre){
            $movieFound->removeGenre($genre);
        }
        
        foreach($genreEntities as $genre){
            $movieFound->addGenre($genre);
        }
        return $movieFound;
    }
}