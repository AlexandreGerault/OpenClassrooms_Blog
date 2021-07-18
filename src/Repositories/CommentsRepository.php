<?php

namespace AGerault\Blog\Repositories;

use AGerault\Blog\Contracts\Repositories\CommentsRepositoryInterface;
use AGerault\Blog\Models\Article;
use AGerault\Blog\Models\Comment;
use AGerault\Framework\Database\QueryBuilder;
use DateTime;
use PDO;

class CommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(protected PDO $pdo) {}

    public function createCommentToBeValidatedToPost(Article $article, array $values): void
    {
        $query = (new QueryBuilder())
            ->from('comments')
            ->insert($values + ['validated' => null, 'article_id' => null, 'created_at' => null])
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindValue(':email', $values['email']);
        $pdo->bindValue(':name', $values['name']);
        $pdo->bindValue(':content', $values['content']);
        $pdo->bindValue(':article_id', $article->id());
        $pdo->bindValue(':validated', 0);
        $pdo->bindValue(':created_at', (new DateTime())->format('Y-m-d H:i:s'));
        $pdo->execute();
    }

    public function allComments(): array
    {
        $query = (new QueryBuilder())
            ->withAliasPrefixOnColumns()
            ->from('comments', 'c')
            ->select(['id', 'email', 'name', 'content', 'validated', 'created_at'])
            ->selectOnJoinTable(['title'])
            ->innerJoin('articles', 'a')
            ->on('c.article_id', 'a.id')
            ->toSQL();

        $pdo = $this->pdo->query($query);
        $pdo->execute();

        return array_map(
            fn (array $values) => new Comment(
                id: $values['comments_id'],
                name: $values['comments_name'],
                email: $values['comments_email'],
                content: $values['comments_content'],
                createdAt: new DateTime($values['comments_created_at']),
                validated: (bool) $values['comments_validated'],
                article: new Article(name: $values['articles_title'])
            ),
            $pdo->fetchAll()
        );
    }

    public function validComment(int $id): void
    {
        $query = (new QueryBuilder())
            ->from('comments', 'c')
            ->update(['validated' => 'validated'])
            ->where('id', '=', ':id')
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindValue(':validated', 1);
        $pdo->bindValue(':id', $id);

        $pdo->execute();
    }

    public function invalidComment(int $id): void
    {
        $query = (new QueryBuilder())
            ->from('comments', 'c')
            ->update(['validated' => 'validated'])
            ->where('id', '=', ':id')
            ->toSQL();

        $pdo = $this->pdo->prepare($query);
        $pdo->bindValue(':validated', 0);
        $pdo->bindValue(':id', $id);

        $pdo->execute();
    }
}
