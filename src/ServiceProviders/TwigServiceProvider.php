<?php

namespace AGerault\Blog\ServiceProviders;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider
{
    public static function make(string $viewPath)
    {
        $twigLoader = new FilesystemLoader($viewPath);

        return new Environment($twigLoader);
    }
}
