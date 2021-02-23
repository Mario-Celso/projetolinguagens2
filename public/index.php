<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');

require __DIR__ . '/../vendor/autoload.php';

if (PHP_SAPI == 'cli-server') {
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__ . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

$builder = new \DI\ContainerBuilder();
$builder->useAnnotations(true);
$builder->addDefinitions(__DIR__ . '/../config/doctrine.php');
$builder->addDefinitions(__DIR__ . '/../config/settings.php');
$builder->addDefinitions(__DIR__ . '/../config/repositories.php');
$builder->addDefinitions(__DIR__ . '/../config/dependencies.php');
$container = $builder->build();

$app = \DI\Bridge\Slim\Bridge::create($container);
$app->add(\Slim\Views\TwigMiddleware::createFromContainer($app));

$bodyParsingMiddleware = $app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, false, false);

/*$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->registerErrorRenderer('text/html', \App\Controller\ErrorHandler\CustomErrorRenderer::class);*/

require __DIR__ . '/../config/routes/system.php';

$app->run();
