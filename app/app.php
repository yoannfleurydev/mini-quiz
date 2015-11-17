<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 11/17/15
 * Time: 4:56 PM
 */
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());

// Register services.
/*$app['dao.article'] = $app->share(function ($app) {
    return new mini-quiz\DAO\nomdelaclasse($app['db']);
});*/