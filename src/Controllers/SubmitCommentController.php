<?php

namespace AGerault\Blog\Controllers;

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Contracts\Repositories\CommentsRepositoryInterface;
use AGerault\Blog\Models\Comment;
use AGerault\Blog\Validators\CommentValidator;
use GuzzleHttp\Psr7\Response;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class SubmitCommentController extends BaseController
{
    public function __construct(
        Environment $twig,
        protected PDO $pdo,
        protected ArticlesRepositoryInterface $articlesRepository,
        protected CommentsRepositoryInterface $commentsRepository
    ) {
        parent::__construct($twig);
    }

    public function __invoke(ServerRequestInterface $request, string $slug, int $id): ResponseInterface
    {
        try {
            $article = $this->articlesRepository->getArticleBySlug($slug);
        } catch (\Exception $e) {
            return new Response(404, [], "Article not found");
        }

        $validator = new CommentValidator($request->getParsedBody(), $this->pdo);

        if ( ! $validator->isValid()) {
            return new Response(400, [], "Bad Request");
        }

        $this->commentsRepository->createCommentToBeValidatedToPost($article, $validator->validated());

        return $this->redirect("/blog/{$slug}/{$id}");
    }
}
