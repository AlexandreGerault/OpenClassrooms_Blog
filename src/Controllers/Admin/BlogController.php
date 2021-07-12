<?php

namespace AGerault\Blog\Controllers\Admin;

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Controllers\BaseController;
use AGerault\Blog\Models\Article;
use AGerault\Blog\Services\AuthService;
use AGerault\Blog\Validators\ArticleValidator;
use DateTime;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Twig\Environment;

class BlogController extends BaseController
{
    public function __construct(
        Environment $twig,
        protected AuthService $auth,
        protected ArticlesRepositoryInterface $repository,
        protected PDO $pdo
    ) {
        parent::__construct($twig);
    }

    public function index(): ResponseInterface
    {
        $posts = $this->repository->getRecentArticlesForPage(0);

        return $this->render('admin/blog/index.html.twig', compact('posts'));
    }

    public function create(): ResponseInterface
    {
        return $this->render('admin/blog/create.html.twig');
    }

    public function store(ServerRequest $request): ResponseInterface
    {
        $validator = new ArticleValidator($request->getParsedBody(), $this->pdo);

        if ( ! $validator->isValid()) {
            return new Response(400, [], "Bad Request");
        }

        $validated = $validator->validated();

        $post = Article::fromArray($validated + ['user' => $this->auth->user(), 'createdAt' => new DateTime()]);
        $this->repository->store($post);

        return $this->redirect('/admin/blog');
    }

    public function edit(ServerRequest $request, string $slug, int $id): ResponseInterface
    {
        $post = $this->repository->getArticleBySlug($slug);

        return $this->render('admin/blog/edit.html.twig', compact('post'));
    }

    public function update(ServerRequest $request)
    {
    }

    public function delete()
    {
    }
}
