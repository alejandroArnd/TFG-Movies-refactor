<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Genre;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Mapper\GenreMapper;
use App\Application\Repository\GenreRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineGenreRepository extends ServiceEntityRepository implements GenreRepository
{
    private GenreMapper $genreMapper;
    public function __construct(ManagerRegistry $registry, GenreMapper $genreMapper)
    {
        parent::__construct($registry, Genre::class);
        $this->genreMapper = $genreMapper;
    }

    public function findOneByName(string $name, bool $isEntity = false): ?object
    {
        $genre = $this->findOneBy(['name' => $name]);
        return (!$genre || $isEntity ) ? $genre : $this->genreMapper->toModel($genre);
    }
}