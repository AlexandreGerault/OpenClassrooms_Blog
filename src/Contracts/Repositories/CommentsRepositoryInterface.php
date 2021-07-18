<?php

namespace AGerault\Blog\Contracts\Repositories;

use AGerault\Blog\Models\Article;

interface CommentsRepositoryInterface
{
    /**
     * @return array<Comment>
     */
    public function allComments(): array;

    public function createCommentToBeValidatedToPost(Article $article, array $values): void;
}
