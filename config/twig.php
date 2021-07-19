<?php

/**
 * @var ApplicationInterface $app
 */

use AGerault\Blog\Services\AuthService;
use AGerault\Blog\Twig\AuthTwigExtension;
use AGerault\Blog\Twig\CsrfTwigExtension;
use AGerault\Blog\Twig\RouteTwigExtension;
use AGerault\Framework\Contracts\Core\ApplicationInterface;
use Grafikart\Csrf\CsrfMiddleware;
use Twig\Environment;
use Twig\Extra\Markdown\DefaultMarkdown;
use Twig\Extra\Markdown\MarkdownExtension;
use Twig\Extra\Markdown\MarkdownRuntime;
use Twig\RuntimeLoader\RuntimeLoaderInterface;
use Twig\TwigTest;

/**
 * @var Environment $twig
 */
$twig = $app->container()->get(Environment::class);

$twig->addExtension(new AuthTwigExtension($app->container()->get(AuthService::class)));
$twig->addExtension(new CsrfTwigExtension($app->container()->get(CsrfMiddleware::class)));
$twig->addExtension(new MarkdownExtension());
$twig->addExtension(new RouteTwigExtension($request));
$twig->addRuntimeLoader(new class implements RuntimeLoaderInterface {
    public function load($class): MarkdownRuntime
    {
        if (MarkdownRuntime::class === $class) {
            return new MarkdownRuntime(new DefaultMarkdown());
        }
    }
});
