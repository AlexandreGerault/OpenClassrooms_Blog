<?php

namespace AGerault\Blog\Contracts\Repositories;

use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;

interface UsersRepositoryInterface
{
    public function register(string $name, string $email, string $password): AuthenticatableInterface;
}
