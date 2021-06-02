<?php

namespace AGerault\Blog\Contracts\Authentication;

use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;

interface UserInterface extends AuthenticatableInterface
{
    public function name(): string;

    public function isValidated(): bool;

    public function isAdmin(): bool;
}
