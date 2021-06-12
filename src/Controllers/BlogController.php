<?php

namespace AGerault\Blog\Controllers;

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class BlogController extends BaseController
{
    protected ArticlesRepositoryInterface $repository;

    public function __construct(Environment $twig, ArticlesRepositoryInterface $repository)
    {
        parent::__construct($twig);
        $this->repository = $repository;
    }

    public function index(): ResponseInterface
    {
        $articles = $this->repository->getRecentArticlesForPage(1);

        return $this->render('blog/index.html.twig', compact('articles'));
    }

    public function show(ServerRequest $request, string $slug, int $id): ResponseInterface
    {
        return $this->render('blog/show.html.twig', compact('slug', 'id'));
    }
}
