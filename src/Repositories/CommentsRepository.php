<?php

namespace AGerault\Blog\Repositories;

use AGerault\Blog\Contracts\Repositories\CommentsRepositoryInterface;
use AGerault\Blog\Models\Article;
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
}
