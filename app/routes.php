<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function() use ($app) {
    $quizzes = $app['dao.quiz']->findAll();
    return $app['twig']->render('index.html.twig', array('quizzes' => $quizzes));
})->bind('home');

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig');
})->bind('login');

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
})->bind('users');

$app->get('/logout', function() use ($app) {
    $app['session']->clear();
    return $app['twig']->render('index.html.twig');
})->bind('logout');

$app->get('/user/{id}', function($id) use ($app) {
    $user = $app['dao.user']->find($id);
    $myquizzes = $app['dao.quiz']->findByAuthor($id);
    return $app['twig']->render('user.html.twig', array('user' => $user, 'myquizzes' => $myquizzes));
})->bind('user');

$app->get('/new/quiz', function() use ($app) {
    return $app['twig']->render('newquiz.html.twig');
})->bind('newquiz');

$app->get('/edit/quiz/{id}', function($id) use ($app) {
    $quiz = $app['dao.quiz']->find($id);
    return $app['twig']->render('editquiz.html.twig', array('quiz' => $quiz));
})->bind('edit/quiz');

$app->match('/edit/quiz_check/{id}', function(Request $request, $id) use ($app) {
    $quiz = $app['dao.quiz']->find($id);
    $title = htmlspecialchars($request->request->get('quiz_title'));
    if ($title != $quiz->getQuizTitle() && !$app['dao.quiz']->titleIsFree($title)) {
        return $app['twig']->render('editquiz.html.twig', array('error' => 'Le titre "' . $title . '" est déjà pris'));
    }
    $description = htmlspecialchars($request->request->get('quiz_description'));
    $app['dao.quiz']->updateQuiz($title, $description, $id);
    $quiz = $app['dao.quiz']->find($id);
    return $app['twig']->render('formAnswer.html.twig', array('quiz' => $quiz));
})->bind('edit/quiz_check');

/************* POST ***************/
$app->post('/login_check', function(Request $request) use ($app) {
    if ($app['dao.user']->verifLogs($request->request->get('user_login'), $request->request->get('user_password'))) {
        $user = $app['dao.user']->findByUserLogin($request->request->get('user_login'));
        $app['session']->set('user', $user);
        $app['session']->set('connected', array('connected' => true));
        return $app['twig']->render('index.html.twig');
    } else {
        return $app['twig']->render('login.html.twig', array('error' => "Mauvaise combinaison d'identifiants"));
    }
})->bind('login_check');

$app->post('/signup_check', function(Request $request) use ($app) {
    //Test if password enter by user are equals
    if ($request->request->get('user_password') !== $request->request->get('user_password2')) {
        return $app['twig']->render('signup.html.twig', array('error' => "Mots de passe non identiques"));
    }

    //test if the login is not already taken
    if (!$app['dao.user']->usernameIsFree($request->request->get('user_login'))) {
        return $app['twig']->render('signup.html.twig', array('error' => "Le pseudo " . $request->request->get('username') . " déjà utilisé"));
    }

    //save the user in the database
    $app['dao.user']->setUser($request->request->get('user_login'), $request->request->get('user_password'));
    $user = $app['dao.user']->findByUserLogin($request->request->get('user_login'));

    //set the session
    $app['session']->set('user', $user);
    $app['session']->set('connected', array('connected' => true));
    return $app['twig']->render('index.html.twig');
})->bind('signup_check');

$app->post('/signup_check_username', function(Request $request) use ($app) {
    return $app['dao.user']->usernameIsFree($request->request->get('user_login'));
})->bind('signup_check_username');

$app->post('/newquiz_check', function(Request $request) use ($app) {
    $title = htmlspecialchars($request->request->get('quiz_title'));
    if (!$app['dao.quiz']->titleIsFree($title)) {
        return $app['twig']->render('newquiz.html.twig', array('error' => 'Le titre "' . $title . '" est déjà pris'));
    }
    $description = htmlspecialchars($request->request->get('quiz_description'));
    $quizId = $app['dao.quiz']->saveQuiz($title, $description, $app['session']->get('user')->getUserId());
    return $app['twig']->render('formAnswer.html.twig', array('quizId' => $quizId));
})->bind('newquiz_check');

$app->post('/newAnswer_check', function(Request $request) use ($app) {
    $answer_content = htmlspecialchars($request->request->get('answer_content'));
    $answer1 = htmlspecialchars($request->request->get('answer_content'));
    $answer2 = htmlspecialchars($request->request->get('answer_content'));
    $answer3 = htmlspecialchars($request->request->get('answer_content'));
    $answer4 = htmlspecialchars($request->request->get('answer_content'));
    if (!$app['dao.quiz']->titleIsFree($title)) {
        return $app['twig']->render('newquiz.html.twig', array('error' => 'Le titre "' . $title . '" est déjà pris'));
    }
    $description = htmlspecialchars($request->request->get('quiz_description'));
    $quizId = $app['dao.quiz']->saveQuiz($title, $description, $app['session']->get('user')->getUserId());
    return $app['twig']->render('formAnswer.html.twig', array('quizId' => $quizId));
})->bind('newAnswer_check');