<?php

/**
 * @var ApplicationInterface $app
 */

use AGerault\Blog\Services\AuthService;
use AGerault\Blog\Twig\AuthTwigExtension;
use AGerault\Framework\Contracts\Core\ApplicationInterface;
use Twig\Environment;
use Twig\TwigTest;

/**
 * @var Environment $twig
 */
$twig = $app->container()->get(Environment::class);

$twig->addExtension(new AuthTwigExtension($app->container()->get(AuthService::class)));
