<?php


namespace AGerault\Blog\Twig;


use AGerault\Blog\Services\AuthService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\GlobalsInterface;

class AuthTwigExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * AuthTwigExtension constructor.
     */
    public function __construct(protected AuthService $auth)
    {
    }

    public function getGlobals(): array
    {
        return [
            'logged' => $this->auth->check(),
            'user' => $this->auth->user()
        ];
    }

    public function getTokenParsers(): array
    {
        return [];
    }
}
