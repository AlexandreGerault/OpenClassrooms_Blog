<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use AGerault\Framework\Core\Application;
use AGerault\Framework\HTTP\HttpRequestHandler;
use AGerault\Framework\HTTP\MiddlewarePipe;
use AGerault\Framework\Routing\RouteCollection;
use AGerault\Framework\Routing\UrlMatcher;
use AGerault\Framework\Services\ServiceContainer;
use GuzzleHttp\Psr7\ServerRequest;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;


setlocale(LC_TIME, 'fr_FR');
$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$request = ServerRequest::fromGlobals();

$app = new Application(new ServiceContainer(), new RouteCollection());
include_once(dirname(__DIR__) . '/config/container.php');

$app->registerRoutes(require dirname(__DIR__) . '/routes/web.php');


$urlMatcher  = new UrlMatcher($app->routes());
$middlewares = new MiddlewarePipe(require dirname(__DIR__) . '/config/middlewares.php');
$httpHandler = new HttpRequestHandler($middlewares);
$response    = $httpHandler->handle($request);

if (headers_sent()) {
    throw new RuntimeException('Headers were already sent. The response could not be emitted!');
}

$statusLine = sprintf(
    'HTTP/%s %s %s',
    $response->getProtocolVersion(),
    $response->getStatusCode(),
    $response->getReasonPhrase()
);
header($statusLine, true); /* The header replaces a previous similar header. */

foreach ($response->getHeaders() as $name => $values) {
    $responseHeader = sprintf(
        '%s: %s',
        $name,
        $response->getHeaderLine($name)
    );
    header($responseHeader, false); /* The header doesn't replace a previous similar header. */
}

echo $response->getBody();
exit();
