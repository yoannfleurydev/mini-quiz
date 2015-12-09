<?php

/************* ADMIN **************/
$app->get('/admin', function () use ($app) {
    if ($app['function.isAdmin']) {
        $users = $app['dao.user']->findAll();
        $quizzes = $app['dao.quiz']->findAll();

        return $app['twig']->render('admin.html.twig', array('users' => $users, 'quizzes' => $quizzes));
    } else {
        $app['session']->getFlashBag()->add('message', array('type' => 'danger', 'content' => 'Cette opération ne vous est pas permise'));

        return $app->redirect('/login');
    }
})->bind('admin');