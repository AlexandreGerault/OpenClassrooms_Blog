<?php

namespace AGerault\Blog\Repositories;

use AGerault\Blog\Contracts\Repositories\UsersRepositoryInterface;
use AGerault\Blog\Models\User;
use AGerault\Framework\Contracts\Authentication\AuthenticatableInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatableProviderInterface;
use AGerault\Framework\Contracts\Authentication\Exceptions\AuthenticatableNotFoundException;
use AGerault\Framework\Database\QueryBuilder;
use PDO;

class UsersRepository implements AuthenticatableProviderInterface, UsersRepositoryInterface
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
            $queryResult['name'],
            $queryResult['email'],
            $queryResult['password']
        ) : throw new AuthenticatableNotFoundException("No user matching credentials has been found");
    }

    public function register(string $name, string $email, string $password): AuthenticatableInterface
    {
        $password = password_hash($password, PASSWORD_ARGON2ID);

        $query = (new QueryBuilder())->insert(['name', 'email', 'password' ])->toSQL();
        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam('name', $name);
        $pdo->bindParam('email', $email);
        $pdo->bindParam('password', $password);
        $result = $pdo->execute();
        dd($result);

        return new User($name, $email, $password);
    }
}
