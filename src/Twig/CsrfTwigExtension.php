<?php


namespace AGerault\Blog\Twig;


use Grafikart\Csrf\CsrfMiddleware;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class CsrfTwigExtension extends AbstractExtension implements ExtensionInterface
{
    public function __construct(protected CsrfMiddleware $middleware)
    {
    }

    public function getFunctions(): array
    {
        $function = new TwigFunction(
            'csrf',
            function () {
                $name  = $this->middleware->getFormKey();
                $value = $this->middleware->generateToken();

                return "<input type='hidden' name='{$name}' value='{$value}' />";
            }
        );

        return [$function];
    }
}
