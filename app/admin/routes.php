<?php

/************* ADMIN **************/
$app->get('/admin', function () use ($app) {
    if ($app['function.isAdmin']) {
        $users   = $app['dao.user']->findAll();
        $quizzes = $app['dao.quiz']->findAll();

        return $app['twig']->render('admin.html.twig', array('users' => $users, 'quizzes' => $quizzes));
    } else {
        return $app['twig']->render('index.html.twig', array('error' => "Vous n'avez pas les droits d'accès
        suffisant pour accéder à cette partie"));
    }
})->bind('admin');