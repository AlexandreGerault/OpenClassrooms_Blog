<?php

namespace AGerault\Blog\Repositories;

use PDO;

class BaseRepository
{
    public function __construct(protected PDO $pdo)
    {
    }
}
