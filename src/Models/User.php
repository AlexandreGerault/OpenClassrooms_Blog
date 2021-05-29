<?php

namespace AGerault\Blog\Models;

use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;

class User implements AuthenticatableInterface
{

    /**
     * User constructor.
     */
    public function __construct(
        protected string $login,
        protected string $password
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
}
