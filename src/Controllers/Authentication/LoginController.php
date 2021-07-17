<?php

namespace AGerault\Blog\Controllers\Authentication;

use AGerault\Blog\Controllers\BaseController;
use AGerault\Blog\Services\AuthService;
use AGerault\Blog\Validators\LoginValidator;
use AGerault\Framework\Contracts\Authentication\Exceptions\AuthenticatableNotFoundException;
use GuzzleHttp\Psr7\Response;
use PDO;
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
        protected AuthService $login,
        protected PDO $PDO
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
        $validator = new LoginValidator($request->getParsedBody(), $this->PDO);
        $validated = $validator->validated();
        if (! $validator->isValid()) {
            return new Response(400, [], implode(', ', $validator->errors()));
        }


        // Authentication
        try {
            $this->login->attempt($validated['email'], $validated['password']);
            return $this->redirect('/');
        } catch (AuthenticatableNotFoundException $exception) {
            return new Response(400, [], $exception->getMessage());
        }

    }
}
