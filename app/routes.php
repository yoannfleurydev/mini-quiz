<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig');
})->bind('login');

$app->post('/login_check', function(Request $request) use ($app) {
    if (null === $request->request->get('username') && null === $request->request->get('password')) {
        if ($app['dao.user']->verifLogs($request->request->get('username'), $request->request->get('password'))) {
            $app['session']->set('user', array('username' => $request->request->get('username')));
        }
    }
    return $app['twig']->render('index.html.twig');
})->bind('login_check');

$app->post('/signup_check', function(Request $request) use ($app) {
    if ('' != $request->request->get('username') && '' != $request->request->get('password')) {
        $app['dao.user']->setUser($request->request->get('username'), $request->request->get('password'));
        $app['session']->set('user', array('username' => $request->request->get('username')));
    }
    return $app['twig']->render('index.html.twig');
})->bind('signup_check');

$app->get('/signup', function() use ($app) {
    return $app['twig']->render('signup.html.twig');
})->bind('signup');

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
});

$app->get('/logout', function() use ($app) {
    $users = $app['dao.user']->findAll();
    return $app['twig']->render('users.html.twig', array('users' => $users));
})->bind('logout');;

$app->get('/user/{id}', function($id) use ($app) {
    $user = $app['dao.user']->find($id);
    return $app['twig']->render('user.html.twig', array('user' => $user));
});