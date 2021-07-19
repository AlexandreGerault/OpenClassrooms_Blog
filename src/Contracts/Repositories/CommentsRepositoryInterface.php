<?php

namespace AGerault\Blog\Contracts\Repositories;

use AGerault\Blog\Models\Article;
use AGerault\Blog\Models\Comment;

interface CommentsRepositoryInterface
{
    /**
     * @return array<Comment>
     */
    public function allComments(): array;

    public function createCommentToBeValidatedToPost(Article $article, array $values): void;

    public function validComment(int $id): void;

    public function invalidComment(int $id): void;

    public function delete(int $id): void;

    public function get(int $id): Comment;
}
