<?php

namespace AGerault\Blog\Controllers\Authentication;

use AGerault\Blog\Contracts\Repositories\UsersRepositoryInterface;
use AGerault\Blog\Controllers\BaseController;
use AGerault\Blog\Services\AuthService;
use AGerault\Blog\Validators\RegistrationValidator;
use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class RegistrationController extends BaseController
{
    /**
     * RegistrationController constructor.
     */
    public function __construct(
        protected Environment $twig,
        protected UsersRepositoryInterface $repository,
        protected AuthService $auth,
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
        return $this->render('auth/register.html.twig');
    }

    private function handleForm(ServerRequestInterface $request): ResponseInterface
    {
        // Validating data
        $validator = new RegistrationValidator($request->getParsedBody(), $this->PDO);
        $validated = $validator->validated();
        if (! $validator->isValid()) {
            return new Response(400, [], implode(', ', $validator->errors()));
        }

        // Authentication
        $name = $validated['name'];
        $email = $validated['email'];
        $password = $validated['password'];

        $this->repository->register($name, $email, $password);
        $this->auth->attempt($email, $password);

        return new Response(200, [], 'User created with success');
    }
}
