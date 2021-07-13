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
                ['a.id', 'a.title', 'a.slug', 'a.chapo', 'a.author_id', 'a.created_at', 'a.updated_at', 'u.name']
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
                createdAt: new DateTime($result['created_at']),
                updatedAt: new DateTime($result['updated_at'])
            ),
            $pdo->fetchAll(PDO::FETCH_ASSOC)
        );
    }

    /** @throws Exception */
    public function getArticleBySlug(string $slug): Article
    {
        $query = (new QueryBuilder())
            ->select(
                [
                    'a.id',
                    'a.title',
                    'a.slug',
                    'a.chapo',
                    'a.content',
                    'a.author_id',
                    'a.created_at',
                    'a.updated_at',
                    'u.name'
                ]
            )
            ->from('articles', 'a')
            ->innerJoin('users', 'u')
            ->on('a.author_id', 'u.id')
            ->where('a.slug', '=', ':slug')
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam(':slug', $slug);
        $pdo->execute();
        $result = $pdo->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            throw new Exception("Article not found");
        }

        return new Article(
            id: $result['id'],
            name: $result['title'],
            slug: $result['slug'],
            chapo: $result['chapo'],
            content: $result['content'],
            author: new User(name: $result['name']),
            createdAt: new DateTime($result['created_at']),
            updatedAt: new DateTime($result['updated_at'])
        );
    }

    public function getArticleById(int $id): Article
    {
        $query = (new QueryBuilder())
            ->select(
                [
                    'a.id',
                    'a.title',
                    'a.slug',
                    'a.chapo',
                    'a.content',
                    'a.author_id',
                    'a.created_at',
                    'a.updated_at',
                    'u.name'
                ]
            )
            ->from('articles', 'a')
            ->innerJoin('users', 'u')
            ->on('a.author_id', 'u.id')
            ->where('a.id', '=', ':id')
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam(':id', $id);
        $pdo->execute();
        $result = $pdo->fetch(PDO::FETCH_ASSOC);

        return new Article(
            id: $result['id'],
            name: $result['title'],
            slug: $result['slug'],
            chapo: $result['chapo'],
            content: $result['content'],
            author: new User(name: $result['name']),
            createdAt: new DateTime($result['created_at']),
            updatedAt: new DateTime($result['updated_at'])
        );
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

    public function update(int $id, array $values): void
    {
        $query = (new QueryBuilder())->from('articles')->update($values)->where('id', '=')->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam(':id', $id);
        $pdo->bindParam(':title', $values['title']);
        $pdo->bindParam(':chapo', $values['chapo']);
        $pdo->bindParam(':content', $values['content']);
        $pdo->bindParam(':slug', $values['slug']);
        $pdo->execute();
    }

    public function delete(int $id): void
    {
        $query = (new QueryBuilder())->from('article')->delete()->where('id', '=')->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindParam(':id', $id);
        $pdo->execute();
    }
}
