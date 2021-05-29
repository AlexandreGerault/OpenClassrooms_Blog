<?php

namespace AGerault\Blog\Controllers\Authentication;

use AGerault\Blog\Controllers\BaseController;
use AGerault\Blog\Services\AuthService;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class LoginController extends BaseController
{
    /**
     * LoginController constructor.
     */
    public function __construct(
        protected Environment $twig,
        protected AuthService $login
    ) {
        parent::__construct($twig);
    }


    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        return match ($request->getMethod()) {
            "GET" => $this->showForm(),
            "POST" => $this->handleForm($request),
            default => new Response(409)
        };
    }

    private function showForm(): ResponseInterface
    {
        return $this->render('auth/login.html.twig');
    }

    private function handleForm(ServerRequestInterface $request): ResponseInterface
    {
        // Validating data
        $body = $request->getParsedBody();

        // Authentication
        $user = $this->login->attempt($body['email'], $body['password']);

        if (! $user) {
            return new Response(400, [], 'Invalid credentials');
        }

        return new Response(200, [], 'Valid credentials');
    }
}
