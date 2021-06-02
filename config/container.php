<?php

use AGerault\Framework\Contracts\Session\SessionInterface;
use Twig\Environment;
use Twig\Loader\LoaderInterface;
use Twig\Loader\FilesystemLoader;
use AGerault\Blog\Repositories\UsersRepository;
use AGerault\Blog\Repositories\ArticlesRepository;
use AGerault\Framework\Contracts\Core\ApplicationInterface;
use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Framework\Authentication\Authenticator;
use AGerault\Framework\Contracts\Authentication\AuthenticatorInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatableProviderInterface;

/**
 * @var ApplicationInterface $app
 */

$app->container()->addFactory(
    Environment::class,
    function () {
        $twigLoader = new FilesystemLoader(dirname(__DIR__) . '/resources/views');

        return new Environment($twigLoader);
    }
);

$app->container()->addFactory(
    PDO::class,
    function () {
        $name = getenv('DB_NAME');
        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');
        return new PDO("mysql:dbname={$name};host={$host};", $user, $pass);
    }
);

$app->container()->addAlias(ArticlesRepositoryInterface::class, ArticlesRepository::class);
$app->container()->addAlias(LoaderInterface::class, FilesystemLoader::class);
$app->container()->addAlias(AuthenticatableProviderInterface::class, UsersRepository::class);
$app->container()->addAlias(AuthenticatorInterface::class, Authenticator::class);
$app->container()->addAlias(SessionInterface::class, \AGerault\Framework\Session\Session::class);

require_once dirname(__DIR__) . '/config/twig.php';
