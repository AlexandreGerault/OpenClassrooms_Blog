<?php

namespace AGerault\Blog\ServiceProviders;

use PDO;

class PdoServiceProvider
{
    public static function make()
    {
        $name = getenv('DB_NAME');
        $host = getenv('DB_HOST');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASSWORD');

        return new PDO("mysql:dbname={$name};host={$host};", $user, $pass);
    }
}
