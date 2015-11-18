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