<?php

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

$app->get('/login', function() use ($app) {
    return $app['twig']->render('login.html.twig');
})->bind('login');

$app->get('/signup', function() use ($app) {
    return $app['twig']->render('signup.html.twig');
})->bind('signup');

$app->get('/quiz', function() use ($app) {
    return $app['twig']->render('quiz.html.twig');
})->bind('quiz');

$app->get('/quiz/{id}', function() use ($app) {
    return $app['twig']->render('quiz_id.html.twig');
});