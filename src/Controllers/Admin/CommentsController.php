<?php

namespace AGerault\Blog\Controllers\Admin;

use AGerault\Blog\Contracts\Repositories\CommentsRepositoryInterface;
use AGerault\Blog\Controllers\BaseController;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class CommentsController extends BaseController
{
    public function __construct(
        protected Environment $twig,
        protected PDO $pdo,
        protected CommentsRepositoryInterface $commentsRepository
    ) {}

    public function index(): ResponseInterface
    {
        $comments = $this->commentsRepository->allComments();

        return $this->render('admin/comments/index.html.twig', compact('comments'));
    }

    public function validComment(ServerRequestInterface $request, int $id): ResponseInterface
    {
        $this->commentsRepository->validComment($id);

        return $this->redirect('/admin/comments');
    }

    public function invalidComment(ServerRequestInterface $request, int $id): ResponseInterface
    {
        $this->commentsRepository->invalidComment($id);

        return $this->redirect('/admin/comments');
    }
}
