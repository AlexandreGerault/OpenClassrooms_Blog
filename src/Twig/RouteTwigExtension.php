<?php

namespace AGerault\Blog\Twig;

use Psr\Http\Message\ServerRequestInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class RouteTwigExtension extends AbstractExtension implements ExtensionInterface
{
    public function __construct(protected ServerRequestInterface $request) {}

    public function getFunctions(): array
    {
        $isCurrentPathFunction = new TwigFunction("isPath", function (string $path) {
            return str_contains($this->request->getUri()->getPath(), $path);
        });

        return [$isCurrentPathFunction];
    }
}
