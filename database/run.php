<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use AGerault\Framework\Core\Application;
use AGerault\Framework\Routing\RouteCollection;
use AGerault\Framework\Services\ServiceContainer;

$app = new Application(new ServiceContainer(), new RouteCollection());
include_once(dirname(__DIR__) . '/config/container.php');

/** @var PDO $pdo */
$pdo = $app->container()->get(PDO::class);

$handle = opendir("database/migrations/");
if (!$handle) {
    throw new Exception("Can't open migrations directory");
}

echo "Ouverture du dossier DB\n";

while (false !== ($entry = readdir($handle))) {
    if(! str_ends_with($entry, '.sql')) {
        continue;
    }

    echo "Executing {$entry} script\n";
    $query = file_get_contents("database/migrations/" . $entry);

    if (! $query) {
        throw new Exception("Cannot open {$entry}, aborting....");
    }

    $pdo->exec($query);
}

echo "All scripts executed\n";
