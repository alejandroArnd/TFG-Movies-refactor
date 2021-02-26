<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Entity\Review;
use Doctrine\Persistence\ManagerRegistry;
use App\Infrastructure\Mapper\ReviewMapper;
use App\Application\Repository\ReviewRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineReviewRepository extends ServiceEntityRepository implements ReviewRepository
{
    private ReviewMapper $reviewMapper;

    public function __construct(ManagerRegistry $registry, ReviewMapper $reviewMapper)
    {
        parent::__construct($registry, Review::class);

        $this->reviewMapper = $reviewMapper;
    }

    public function save($review): void
    {
        $reviewToSave = $this->reviewMapper->toEntity($review);
        $this->getEntityManager()->persist($reviewToSave);
        $this->getEntityManager()->flush();
    }

    public function findByIdMovie($movieId): array
    {
        return $this->reviewMapper->toArrayModel($this->findBy(['movies' => $movieId]));
    }

}
