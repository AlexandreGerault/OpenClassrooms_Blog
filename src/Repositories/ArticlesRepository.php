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
        $query = (new QueryBuilder())
            ->select(['a.id', 'a.title', 'a.slug', 'a.chapo', 'a.content', 'a.author_id', 'a.updated_at', 'u.name'])
            ->from('articles', 'a')
            ->innerJoin('users', 'u')
            ->on('a.author_id', 'u.id')
            ->where('a.slug', '=', ':slug')
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam(':slug', $slug);
        $pdo->execute();
        $result = $pdo->fetch(PDO::FETCH_ASSOC);

        return new Article(
            id: $result['id'],
            name: $result['title'],
            slug: $result['slug'],
            chapo: $result['chapo'],
            content: $result['content'],
            author: new User(name: $result['name']),
            updatedAt: new DateTime($result['updated_at'])
        );
    }

    public function getArticleById(int $id): Article
    {
        // TODO: Implement getArticleById() method.
    }

    public function store(Article $post): void
    {
        $query = (new QueryBuilder())
            ->from('articles')
            ->insert(
                [
                    'title'      => 'title',
                    'slug'       => 'slug',
                    'chapo'      => 'chapo',
                    'content'    => 'content',
                    'author_id'  => 'author_id',
                    'created_at' => 'created_at',
                    'updated_at' => 'updated_at'
                ]
            )
            ->toSQL();

        $executeArray = [
            ':title'      => $post->name(),
            ':slug'       => $post->slug(),
            ':chapo'      => $post->chapo(),
            ':content'    => $post->content(),
            ':author_id'  => $post->author()->id(),
            ':created_at' => $post->created_at()->format('Y-m-d H:i:s'),
            ':updated_at' => $post->created_at()->format('Y-m-d H:i:s'),
        ];
        $pdo          = $this->pdo->prepare($query);
        $pdo->execute($executeArray);
    }
}
