<?php

namespace AGerault\Blog\Models;

use AGerault\Blog\Contracts\Authentication\UserInterface;

class User implements UserInterface
{

    /**
     * User constructor.
     */
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?string $login = null,
        protected ?string $password = null,
        protected ?bool $isValidated = false,
        protected ?bool $isAdmin = false
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }

    public function key(): int|string
    {
        return $this?->login();
    }

    public function login(): string
    {
        return $this?->login;
    }

    public function password(): string
    {
        return $this?->password;
    }

    public function isAdmin(): bool
    {
        return $this?->isAdmin ?? false;
    }

    public function name(): string
    {
        return $this?->name;
    }

    public function isValidated(): bool
    {
        return $this?->isValidated ?? false;
    }
}
