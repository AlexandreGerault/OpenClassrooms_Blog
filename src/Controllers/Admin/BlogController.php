<?php

namespace AGerault\Blog\Controllers\Admin;

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Controllers\BaseController;
use AGerault\Blog\Services\AuthService;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class BlogController extends BaseController
{
    public function __construct(
        Environment $twig,
        protected AuthService $auth,
        protected ArticlesRepositoryInterface $repository
    ) {
        parent::__construct($twig);
    }

    private function checkAccess(): ?Response
    {
        if ( ! $this->auth->check()) {
            return new Response(401, [], "Unauthorized");
        }

        return null;
    }

    public function index(): ResponseInterface
    {
        $response = $this->checkAccess();
        if ($response) {
            return $response;
        }

        $posts = $this->repository->getRecentArticlesForPage(0);

        return $this->render('admin/blog/index.html.twig', compact('posts'));
    }

    public function show()
    {
        return "Admin blog show";
    }

    public function create()
    {
        return $this->render('admin/blog/create.html.twig');
    }

    public function store()
    {
    }

    public function edit()
    {
        return "Admin blog edit";
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
