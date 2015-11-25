<?php

/************* ADMIN **************/
$app->get('/admin', function () use ($app) {
    $user = $app['session']->get('user');

    if(!isset($user)) {
        return $app['twig']->render('index.html.twig', array('error' => "Vous devez être connecté et avoir les
        droits suffisant pour accéder à cette partie"));
    }

    $userAccessId = $user->getUserAccessId();
    $userAccess = $app['dao.access']->find($userAccessId);

    if ($userAccess->getAccessKey() === 'ADMIN') {
        $users = $app['dao.user']->findAll();
        $quizzes = $app['dao.quiz']->findAll();

        return $app['twig']->render('admin.html.twig', array('users' => $users, 'quizzes' => $quizzes));
    } else {
        return $app['twig']->render('index.html.twig', array('error' => "Vous n'avez pas les droits d'accès
        suffisant pour accéder à cette partie"));
    }
})->bind('admin');