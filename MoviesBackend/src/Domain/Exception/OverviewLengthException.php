<?php

namespace App\Domain\Exception;

use Exception;

class OverviewLengthException extends Exception
{
    public function __construct()
    {
        parent::__construct("Overview must have 1000 characters", 400);
    }
}