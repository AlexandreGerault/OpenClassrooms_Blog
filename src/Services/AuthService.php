<?php

namespace AGerault\Blog\Services;

use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatableProviderInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatorInterface;
use AGerault\Framework\Contracts\Authentication\Exceptions\AuthenticatableNotFoundException;
use AGerault\Framework\Contracts\Session\SessionInterface;

class AuthService
{
    public function __construct(
        protected AuthenticatableProviderInterface $provider,
        protected AuthenticatorInterface $authenticator,
        protected SessionInterface $session
    ) {
    }

    public function attempt(string $login, string $password): AuthenticatableInterface
    {
        $user = $this->authenticator->attempt(
            $this->provider->fetch($login),
            ['login' => $login, 'password' => $password]
        ) ?? throw new AuthenticatableNotFoundException("Wrong credentials");

        $this->session->put('auth', $user);

        return $user;
    }

    public function check(): bool
    {
        return $this->session->has('auth');
    }

    public function user(): ?AuthenticatableInterface
    {
        return $this->session->get('auth');
    }
}
