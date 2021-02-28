<?php

namespace App\Domain\Model;

class UserModel
{
    private $id;
    private $username;
    private $roles = [];
    private $password;
    private $email;

    public function __construct(string $username, string $email, array $roles = null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->roles = $roles ? $roles : ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
