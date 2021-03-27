<?php

namespace App\Infrastrcture\Service;

use DateTime;
use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class QueryBuilderMovie
{
    private QueryBuilder $queryBuilder;
    
    public function createQueryBuilderMovie($builder): self
    {
        $this->queryBuilder = $builder->createQueryBuilder('m')->select('m');

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

    public function addSearchByReleaseDateGreaterThanActualDate(): self
    {
        $today = new DateTime();
        $this->queryBuilder = $this->queryBuilder->andWhere($this->queryBuilder->expr()->gt('m.releaseDate', "'".$today->format('Y-m-d')."'"));

        return $this;
    }

    public function addSelectAvgScoreMovie() :self
    {
        $this->queryBuilder = $this->queryBuilder->addSelect($this->queryBuilder->expr()->avg('review.score'))
        ->leftJoin('m.reviews','review')
        ->groupBy('m.id');

        return $this;
    }

    public function orderMoviesBy($sort, $order = "DESC"): self
    {
        $this->queryBuilder = $this->queryBuilder->groupBy('m.id')->orderBy($sort, $order);

        return $this;
    }

    public function getExprQuery(): Expr
    {
        return $this->queryBuilder->expr();
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

    public function setMaxResultsQuery($maxResults): self
    {
        $this->queryBuilder = $this->queryBuilder->setMaxResults($maxResults);

        return $this;
    }
}