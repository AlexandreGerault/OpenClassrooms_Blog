<?php

namespace AGerault\Blog\Repositories;

use AGerault\Blog\Models\User;
use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatableProviderInterface;
use AGerault\Framework\Contracts\Authentication\Exceptions\AuthenticatableNotFoundException;
use PDO;

class UsersRepository implements AuthenticatableProviderInterface
{
    public function __construct(protected PDO $pdo)
    {
    }

    /**
     * @throws AuthenticatableNotFoundException
     */
    public function fetch(int|string $key): AuthenticatableInterface
    {
        $query = $this->pdo->prepare('SELECT * FROM users WHERE email = :email;');
        $query->bindParam(':email', $key);
        $query->execute();
        $queryResult = $query->fetch(PDO::FETCH_ASSOC);

        return $queryResult ? new User(
            $queryResult['email'],
            $queryResult['password']
        ) : throw new AuthenticatableNotFoundException("No user matching credentials has been found");
    }
}
