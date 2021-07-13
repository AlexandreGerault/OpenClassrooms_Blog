<?php

use AGerault\Framework\Contracts\Routing\UrlMatcherInterface;
use AGerault\Framework\Contracts\Session\SessionInterface;
use AGerault\Framework\Core\Application;
use AGerault\Framework\HTTP\Middlewares\HttpMethodMiddleware;
use AGerault\Framework\HTTP\Middlewares\RouteProcessMiddleware;
use AGerault\Framework\HTTP\Middlewares\StartSessionMiddleware;
use Grafikart\Csrf\CsrfMiddleware;

/** @var Application $app */
/** @var UrlMatcherInterface $urlMatcher */
$session = $app->container()->get(SessionInterface::class);
return [
    new HttpMethodMiddleware(),
    new StartSessionMiddleware($session),
    new CsrfMiddleware($session),
    new RouteProcessMiddleware($urlMatcher)
];
