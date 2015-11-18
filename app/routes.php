<?php

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/login', function() use ($app) {
    return $app['twig']->render('login.html.twig');
});

$app->get('/signup', function() use ($app) {
    return $app['twig']->render('index.html.twig');
});

$app->get('/quiz', function() use ($app) {
    return $app['twig']->render('quiz.html.twig');
});

$app->get('/quiz/{id}', function() use ($app) {
    return $app['twig']->render('quiz_id.html.twig');
});