<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig');
})->bind('login');

$app->post('/login_check', function(Request $request) use ($app) {
    if ($app['dao.user']->verifLogs($request->request->get('username'), $request->request->get('password'))) {
        $app['session']->set('user', array('username' => $request->request->get('username')));
        $app['session']->set('connected', array('connected' => true));
        return $app['twig']->render('index.html.twig');
    } else {
        return $app['twig']->render('login.html.twig', array('error' => "Mauvaise combinaison d'identifiants"));
    }
})->bind('login_check');

$app->post('/signup_check', function(Request $request) use ($app) {
    $app['dao.user']->setUser($request->request->get('username'), $request->request->get('password'));
    $app['session']->set('user', array('username' => $request->request->get('username')));
    $app['session']->set('connected', array('connected' => true));
    return $app['twig']->render('index.html.twig');
})->bind('signup_check');

$app->get('/signup', function() use ($app) {
    return $app['twig']->render('signup.html.twig');
})->bind('signup');

$app->get('/signup_check_username', function() use ($app) {
    $app['dao.user']->usernameIsFree();
    return $app['twig']->render('signup.html.twig');
})->bind('signup_check_username');

$app->get('/quiz', function() use ($app) {
    return $app['twig']->render('quiz.html.twig');
})->bind('quiz');

$app->get('/quiz/{id}', function($id) use ($app) {
    //$app['dao.quiz']->find($id);

    return $app['twig']->render('quiz_id.html.twig');
});

$app->get('/users', function() use ($app) {
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('users.html.twig', array('users' => $users));
})->bind('users');

$app->get('/logout', function() use ($app) {
    $app['session']->clear();
    return $app['twig']->render('index.html.twig');
})->bind('logout');

$app->get('/user/{id}', function($id) use ($app) {
    $user = $app['dao.user']->find($id);
    return $app['twig']->render('user.html.twig', array('user' => $user));
})->bind('user');