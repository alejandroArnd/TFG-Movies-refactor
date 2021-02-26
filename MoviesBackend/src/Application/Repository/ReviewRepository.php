<?php

namespace App\Application\Repository;

use App\Domain\Model\ReviewModel;

interface ReviewRepository
{
    public function save(ReviewModel $review): void;
    
}
