<?php

namespace AGerault\Blog\Models;

use AGerault\Blog\Contracts\Authentication\UserInterface;

class User implements UserInterface
{

    /**
     * User constructor.
     */
    public function __construct(
        protected string $name,
        protected string $login,
        protected string $password,
        protected bool $isValidated,
        protected bool $isAdmin,
    ) {
    }

    public function key(): int|string
    {
        return $this->login();
    }

    public function login(): string
    {
        return $this->login;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function isValidated(): bool
    {
        return $this->isValidated;
    }
}
