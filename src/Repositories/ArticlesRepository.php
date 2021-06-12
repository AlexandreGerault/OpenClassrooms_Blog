<?php

namespace AGerault\Blog\Repositories;

use AGerault\Blog\Contracts\Repositories\ArticlesRepositoryInterface;
use AGerault\Blog\Models\Article;
use AGerault\Blog\Models\User;
use AGerault\Framework\Database\QueryBuilder;
use DateTime;
use Exception;
use PDO;

class ArticlesRepository extends BaseRepository implements ArticlesRepositoryInterface
{
    public function getRecentArticlesForPage(int $page, int $quantity = 9): array
    {
        $query = (new QueryBuilder())
            ->select(
                ['a.id', 'a.title', 'a.slug', 'a.chapo', 'a.author_id', 'a.updated_at', 'u.name']
            )
            ->from('articles', 'a')
            ->innerJoin('users', 'u')
            ->on('a.author_id', 'u.id');

        $pdo = $this->pdo->prepare($query->toSQL());
        $pdo->execute();

        return array_map(
        /** @throws Exception */
            fn($result) => new Article(
                id: $result['id'],
                name: $result['title'],
                slug: $result['slug'],
                chapo: $result['chapo'],
                author: new User(name: $result["name"]),
                updatedAt: new DateTime($result['updated_at'])
            ),
            $pdo->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /** @throws Exception */
    public function getArticleBySlug(string $slug): Article
    {
    }

    public function getArticleById(int $id): Article
    {
    }
}
