<?php

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Repositories\ArticlesRepository;

$app->container()->addAlias(ArticlesRepositoryInterface::class, ArticlesRepository::class);
$app->container()->addAlias(\Twig\Loader\LoaderInterface::class, \Twig\Loader\FilesystemLoader::class);

$app->container()->addFactory(\Twig\Environment::class, function () {
    $twigLoader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/resources/views');
    return new \Twig\Environment($twigLoader);
});