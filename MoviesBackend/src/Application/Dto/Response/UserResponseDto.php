<?php

namespace App\Applocation\Dto\Response;

class UserResponseDto
{
    public string $username;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

}