<?php

namespace AGerault\Blog\Contracts\Repositories;

use AGerault\Blog\Models\Article;

interface ArticlesRepositoryInterface
{
    /** @return Article[] */
    public function getRecentArticlesForPage(int $page): array;

    public function getArticleBySlug(string $slug): Article;

    public function getArticleBySlugWithValidatedComments(string $slug): Article;

    public function getArticleById(int $id): Article;

    public function store(Article $post): void;

    public function update(int $id, array $values): void;

    public function delete(int $id): void;
}
