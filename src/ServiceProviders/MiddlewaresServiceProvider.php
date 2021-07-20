<?php

namespace AGerault\Blog\ServiceProviders;

use AGerault\Framework\Contracts\Services\ServiceContainerInterface;
use AGerault\Framework\Contracts\Session\SessionInterface;
use Grafikart\Csrf\CsrfMiddleware;

class MiddlewaresServiceProvider
{
    public static function makeCsrf(ServiceContainerInterface $container)
    {
        $session = $container->get(SessionInterface::class);

        return new CsrfMiddleware($session);
    }
}
