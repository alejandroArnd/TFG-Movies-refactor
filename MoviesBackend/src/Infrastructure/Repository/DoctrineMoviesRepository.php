<?php

namespace App\Infrastructure\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Application\Repository\MoviesRepository;
use App\Domain\Entity\Movies;

class DoctrineMoviesRepository extends ServiceEntityRepository implements MoviesRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movies::class);
    }

    public function getAll(): array
    {
        return $this->findAll();
    }

    public function save(Movies $movies):void
    {
        $this->getEntityManager()->persist($movies);
        $this->getEntityManager()->flush();
    }

    public function findById(int $id): ?Movies
    {
        return $this->find($id);
    }

    public function findOneByTitle(string $title): ?Movies
    {
        return $this->findOneBy(['title' => $title]);
    }

    public function findByTitle(string $title): array
    {
        $queryBuilder = $this->createQueryBuilder('m');
        return $queryBuilder->where($queryBuilder->expr()->like('m.title',':title'))
                ->setParameter('title','%'.$title.'%')
                ->getQuery()
                ->getResult();
    }

}