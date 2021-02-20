<?php

namespace App\Domain\Exception;

use Exception;

class OverviewLengthException extends Exception
{
    public function errorMessage()
    {
        return ["message" => "Overview must have 1000 characters", "status" => 400];
    }
}