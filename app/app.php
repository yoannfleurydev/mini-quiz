<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
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

$app['dao.question'] = $app->share(function ($app) {
    return new Miniquiz\DAO\QuestionDAO($app['db']);
});

$app['dao.answer'] = $app->share(function ($app) {
    return new Miniquiz\DAO\AnswerDAO($app['db']);
});

$app['dao.quizsave'] = $app->share(function ($app) {
    return new Miniquiz\DAO\QuizSaveDAO($app['db']);
});


$app['function.isAdmin'] = $app->share(function($app) {
    $user = $app['session']->get('user');
    if (isset($user)) {
        $userAccessId = $user->getUserAccessId();
        $userAccess = $app['dao.access']->find($userAccessId);
        return ($userAccess->getAccessKey() === 'ADMIN');
    }
    return false;
});