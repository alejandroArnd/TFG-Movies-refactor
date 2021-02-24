<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\MoviesModel;
use App\Infrastructure\Entity\Movies;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Mapper\MovieMapper;
use App\Application\Repository\MoviesRepository;
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

    public function findByTitle(string $title): array
    {
        $queryBuilder = $this->createQueryBuilder('m');
        $movies = $queryBuilder->where($queryBuilder->expr()->like('m.title',':title'))
                ->setParameter('title','%'.$title.'%')
                ->getQuery()
                ->getResult();

        return $this->movieMapper->toArrayModel($movies);
    }

    private function update($movieModel)
    {
        $movieFound = $this->find($movieModel->getId());
        $movieFound->setTitle($movieModel->getTitle());
        $movieFound->setOverview($movieModel->getOverview());
        $movieFound->setReleaseDate($movieModel->getReleaseDate());
        $movieFound->setDuration($movieModel->getDuration());
        $movieFound->setIsDeleted($movieModel->getIsDeleted());
        return $movieFound;
    }
}