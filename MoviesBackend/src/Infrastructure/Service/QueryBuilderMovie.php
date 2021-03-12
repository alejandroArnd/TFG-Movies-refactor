<?php

namespace App\Infrastrcture\Service;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QueryBuilderMovie
{
    private QueryBuilder $queryBuilder;
    
    public function createQueryBuilderMovie($builder): self
    {
        $this->queryBuilder = $builder->createQueryBuilder('m');

        return $this;
    }

    public function addSearchByTitle($title): self
    {
        $this->queryBuilder = $this->queryBuilder->where($this->queryBuilder->expr()->like('m.title',':title'))
                ->setParameter('title','%'.$title.'%');
        
        return $this;
    }

    public function addSearchByGenres($criteriaParams): self
    {
        if(!empty($criteriaParams->genres)){
            $this->queryBuilder = $this->queryBuilder->innerJoin('m.genres','genre')
                    ->andWhere($this->queryBuilder->expr()->in('genre.name',$criteriaParams->genres))
                    ->groupBy('m.id, m.title, m.overview, m.accessiblePath, m.releaseDate')
                    ->having('COUNT(m.id) = :count')
                    ->setParameter('count', count($criteriaParams->genres));
        }

        return $this;
    }

    public function getPaginateResultQuery(int $limitPerPage, int $page ): array
    {
        $paginator=new Paginator($this->queryBuilder);
        $paginator->getQuery()
            ->setFirstResult($limitPerPage*($page-1))
            ->setMaxResults($limitPerPage);

        return [iterator_to_array($paginator->getIterator()), $paginator->count()];
    }

    public function getResultOfQuery(): array
    {
        return $this->queryBuilder->getQuery()->getResult();
    }
}