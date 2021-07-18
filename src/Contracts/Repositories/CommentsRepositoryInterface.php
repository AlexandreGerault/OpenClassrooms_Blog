<?php

namespace AGerault\Blog\Contracts\Repositories;

use AGerault\Blog\Models\Article;

interface CommentsRepositoryInterface
{
    public function createCommentToBeValidatedToPost(Article $article, array $values): void;
}
