<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__ . '/../views',));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

// Register services.
$app['dao.user'] = $app->share(function ($app) {
    return new Miniquiz\DAO\UserDAO($app['db']);
});

$app['dao.quiz'] = $app->share(function ($app) {
    return new Miniquiz\DAO\QuizDAO($app['db']);
});

$app['dao.access'] = $app->share(function ($app) {
    return new Miniquiz\DAO\AccessDAO($app['db']);
});