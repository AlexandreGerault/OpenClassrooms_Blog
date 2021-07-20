<?php

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Contracts\Repositories\CommentsRepositoryInterface;
use AGerault\Blog\Contracts\Repositories\UsersRepositoryInterface;
use AGerault\Blog\Contracts\Services\MailerInterface;
use AGerault\Blog\Repositories\ArticlesRepository;
use AGerault\Blog\Repositories\CommentsRepository;
use AGerault\Blog\Repositories\UsersRepository;
use AGerault\Blog\ServiceProviders\MailServiceProvider;
use AGerault\Blog\ServiceProviders\MiddlewaresServiceProvider;
use AGerault\Blog\ServiceProviders\PdoServiceProvider;
use AGerault\Blog\ServiceProviders\TwigServiceProvider;
use AGerault\Blog\Services\Mailer;
use AGerault\Framework\Authentication\Authenticator;
use AGerault\Framework\Contracts\Authentication\AuthenticatableProviderInterface;
use AGerault\Framework\Contracts\Authentication\AuthenticatorInterface;
use AGerault\Framework\Contracts\Core\ApplicationInterface;
use AGerault\Framework\Contracts\Session\SessionInterface;
use AGerault\Framework\Session\Session;
use Grafikart\Csrf\CsrfMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Loader\LoaderInterface;

/**
 * @var ApplicationInterface $app
 */

$app->container()->addFactory(
    Environment::class,
    TwigServiceProvider::class,
    "make",
    dirname(__DIR__) . '/resources/views'
);

$app->container()->addFactory(
    PDO::class,
    PdoServiceProvider::class,
    "make"
);


$app->container()->addAlias(ArticlesRepositoryInterface::class, ArticlesRepository::class);
$app->container()->addAlias(CommentsRepositoryInterface::class, CommentsRepository::class);
$app->container()->addAlias(LoaderInterface::class, FilesystemLoader::class);
$app->container()->addAlias(AuthenticatableProviderInterface::class, UsersRepository::class);
$app->container()->addAlias(UsersRepositoryInterface::class, UsersRepository::class);
$app->container()->addAlias(AuthenticatorInterface::class, Authenticator::class);
$app->container()->addAlias(SessionInterface::class, Session::class);
$app->container()->addAlias(MailerInterface::class, Mailer::class);

$app->container()->addFactory(
    CsrfMiddleware::class,
    MiddlewaresServiceProvider::class,
    "makeCsrf",
    $app->container()
);

$app->container()->addAlias(Swift_Transport::class, Swift_SmtpTransport::class);
$app->container()->addFactory(
    Swift_SmtpTransport::class,
    MailServiceProvider::class,
    "make",
    getenv('SMTP_HOST'),
    getenv('SMTP_PORT'),
    getenv('SMTP_USERNAME'),
    getenv('SMTP_PASSWORD')
);

require_once dirname(__DIR__) . '/config/twig.php';
