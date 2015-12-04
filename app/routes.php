<?php

use Symfony\Component\HttpFoundation\Request;

$app->get('/', function () use ($app) {
    $quizzes = $app['dao.quiz']->findAll();

    return $app['twig']->render('index.html.twig', array('quizzes' => $quizzes));
})->bind('home');

$app->get('/login', function (Request $request) use ($app) {
    return $app['twig']->render('login.html.twig');
})->bind('login');

$app->get('/signup', function () use ($app) {
    return $app['twig']->render('signup.html.twig');
})->bind('signup');

$app->get('/quiz', function () use ($app) {
    return $app['twig']->render('quiz.html.twig');
})->bind('quiz');

$app->get('/quiz/{id}', function ($id) use ($app) {
    //$app['dao.quiz']->find($id);

    return $app['twig']->render('quiz_id.html.twig');
});

$app->get('/users', function () use ($app) {
    $users = $app['dao.user']->findAll();

    return $app['twig']->render('users.html.twig', array('users' => $users));
})->bind('users');

$app->get('/logout', function () use ($app) {
    $app['session']->clear();

    return $app->redirect('/');
})->bind('logout');

$app->get('/user/{id}', function ($id) use ($app) {
    $user = $app['dao.user']->find($id);
    $myquizzes = $app['dao.quiz']->findByAuthor($id);

    return $app['twig']->render('user.html.twig', array('user' => $user, 'myquizzes' => $myquizzes));
})->bind('user');

$app->get('/new/quiz', function () use ($app) {
    return $app['twig']->render('newquiz.html.twig');
})->bind('newquiz');

$app->get('/edit/quiz/{id}', function ($id) use ($app) {
    $quiz = $app['dao.quiz']->find($id);

    return $app['twig']->render('editquiz.html.twig', array('quiz' => $quiz));
})->bind('edit/quiz');

$app->match('/answerQuiz/{id}/{questionNumber}', function (Request $request, $id, $questionNumber) use ($app) {
    if ($request->request->get('next')) {
        $questionNumber++;
    }
    $quiz = $app['dao.quiz']->find($id);
    $questions_id = $app['dao.quiz']->getQuestionByQuiz($id);
    $questions = array();
    foreach ($questions_id as $question_id) {
        $question = $app['dao.question']->find($question_id);
        if ($question != null) {
            $question->setAnswers($app['dao.answer']->findByIdQuestion($question_id));
            array_push($questions, $question);
        }
    }
    if ($questionNumber >= count($questions)) {
        return $app['twig']->render('endQuiz.html.twig');
    }
    return $app['twig']->render('answerQuiz.html.twig',
        array('quiz' => $quiz, 'question' => $questions[$questionNumber], 'questionNumber' => $questionNumber));
})->bind('answerQuiz');

$app->match('/edit/quiz_check/{id}', function (Request $request, $id) use ($app) {
    $quiz = $app['dao.quiz']->find($id);
    $title = htmlspecialchars($request->request->get('quiz_title'));
    if ($title != $quiz->getQuizTitle() && !$app['dao.quiz']->titleIsFree($title)) {
        $app['session']->getFlashBag()->add('message'
            , array('type' => 'danger', 'content' => 'Le titre "' . $title . '" est déjà pris'));

        return $app->redirect('/edit/quiz');
    }
    $description = htmlspecialchars($request->request->get('quiz_description'));
    $app['dao.quiz']->updateQuiz($title, $description, $id);
    $questions_id = $app['dao.quiz']->getQuestionByQuiz($id);
    $questions = array();
    foreach ($questions_id as $question_id) {
        $question = $app['dao.question']->find($question_id);
        if ($question != null) {
            array_push($questions, $question);
        }
    }
    $quiz = $app['dao.quiz']->find($id);

    return $app['twig']->render('formAnswer.html.twig', array('quiz' => $quiz, 'questions' => $questions));
})->bind('edit/quiz_check');

$app->get('/delete/user/{id}', function ($id) use ($app) {
    // Si aucun utilisateur n'est connecté, alors on autorise rien.
    if (null === $user = $app['session']->get('user')) {
        $app['session']->getFlashBag()->add('message', array('type' => 'danger', 'content' => 'Cette opération ne vous est pas permise'));

        return $app->redirect('/login');
    }

    // Si l'utilisateur est admin, alors il peut supprimer un utilisateur.
    if ($app['function.isAdmin']) {
        $app['dao.user']->deleteId($id);
        $app['session']->getFlashBag()->add('message', array('content' => 'L\'utilisateur a bien été supprimé', 'type' => 'warning'));

        return $app->redirect('/admin');
    }

    // Si l'utilisateur à supprimer est l'utilisateur actuel, on autorise la suppression.
    if ($user->getUserId() === $id) {
        $app['dao.user']->deleteId($id);
        $app['session']->clear();
        $app['session']->getFlashBag()->add('message', array('content' => 'Votre compte a bien été supprimé', 'type' => 'success'));

        return $app->redirect($app['url_generator']->generate('home'), 303); // 303 See Other - la réponse à la requête
        // est ailleurs
    }

    $app['session']->getFlashBag()->add('message', array('content' => 'Vous n\'êtes pas autorisé à effectuer cette
    action', 'type' => 'warning'));

    return $app->redirect($app['url_generator']->generate('home'), 303); // 303 See Other
})->bind('deleteuser');


$app->get('/delete/quiz/{id}', function ($id) use ($app) {
    // Si aucun utilisateur n'est connecté, alors on autorise rien.
    if (null === $user = $app['session']->get('user')) {
        $app['session']->getFlashBag()->add('message', array('type' => 'danger', 'content' => 'Cette opération ne vous est pas permise'));

        return $app->redirect('/login');
    }

    // Si l'utilisateur est admin, alors il peut supprimer un quiz.
    if ($app['function.isAdmin']) {
        $app['dao.quiz']->deleteId($id);
        $app['session']->getFlashBag()->add('message', array('content' => 'Le quiz a bien été supprimé', 'type' =>
            'success'));

        return $app->redirect('/admin');
    }

    $quiz = $app['dao.quiz']->find($id);

    // Si le quiz à supprimer appartient à l'utilisateur actuel, on autorise la suppression.
    if ($user->getUserId() === $quiz->getQuizUserId()) {
        $app['dao.quiz']->deleteId($id);
        $app['session']->getFlashBag()->add('message', array(
            'content' => 'Le quiz a bien été supprimé',
            'type' => 'success')
        );

        return $app->redirect($app['url_generator']->generate('home'));
    }

    $app['session']->getFlashBag()->add('message', array('content' => 'Vous n\'êtes pas autorisé à effectuer cette
    action', 'type' => 'warning'));

    return $app->redirect($app['url_generator']->generate('home'), 303); // 303 See Other
})->bind('deletequiz');

$app->get('/edit/user/{id}', function ($id) use ($app) {
    // Si aucun utilisateur n'est connecté, alors on autorise rien.
    if (null === $user = $app['session']->get('user')) {
        $app['session']->getFlashBag()->add('message', array('type' => 'danger', 'content' => 'Cette opération ne vous est pas permise'));

        return $app->redirect('/login');
    }

    // Si l'utilisateur est admin, alors il peut modifier un utilisateur.
    if ($app['function.isAdmin'] || $user->getUserId() === $id) {
        $quizzes = $app['dao.quiz']->findByAuthor($id);
        $editUser = $app['dao.user']->find($id);

        return $app['twig']->render('edituser.html.twig', array('user' => $editUser, 'myquizzes' => $quizzes));
    }

    $app['session']->getFlashBag()->add('message', array('content' => 'Cette opération ne vous est pas permise', 'type' => 'danger'));

    return $app->redirect($app['url_generator']->generate('home'), 303); // 303 See Other
})->bind('edituser');

/************* POST ***************/
$app->post('/login_check', function (Request $request) use ($app) {
    if ($app['dao.user']->verifLogs($request->request->get('user_login'), $request->request->get('user_password'))) {
        $user = $app['dao.user']->findByUserLogin($request->request->get('user_login'));
        $app['session']->set('user', $user);
        $app['session']->set('connected', array('connected' => true));

        return $app->redirect('/');
    } else {
        $app['session']->getFlashBag()->add('message',
            array(
                'type' => 'danger',
                'content' => 'Mauvaise combinaison d\'identifiants.'
            )
        );
        return $app->redirect('/login');
    }
})->bind('login_check');

$app->post('/signup_check', function (Request $request) use ($app) {
    // Si l'identifiant de connexion n'est pas assez grand, on prévient l'utilisateur.
    if (strlen($request->request->get('user_login')) < 3) {
        $app['session']->getFlashBag()->add('message',
            array(
                'type' => 'danger',
                'content' => 'Votre identifiant de connexion doit avoir une longueur minimale de 3 caractères.'
            )
        );

        return $app->redirect('/signup');
    }

    // Si le mot de passe n'est pas assez grand, on prévient l'utilisateur en lui indiquant comment mettre un bon mot
    // de passe.
    if (strlen($request->request->get('user_password')) < 4) {
        $app['session']->getFlashBag()->add('message',
            array(
                'type' => 'danger',
                'content' => 'Votre mot de passe doit avoir une longueur minimale de 5 caractères. Nous vous
                conseillons l\'utilisation d\'un mot de passe composé de lettres, majuscules et miniscules ainsi que
                de caractères numériques et de symboles.'
            )
        );

        return $app->redirect('/signup');
    }


    //Test if password enter by user are equals
    if ($request->request->get('user_password') !== $request->request->get('user_password2')) {
        $app['session']->getFlashBag()->add('message'
            , array('type' => 'danger', 'content' => 'Mots de passe non identiques'));

        return $app->redirect('/signup');
    }

    //test if the login is not already taken
    if (!$app['dao.user']->usernameIsFree($request->request->get('user_login'))) {
        $app['session']->getFlashBag()->add('message'
            , array('type' => 'danger', 'content' => "Le pseudo " . $request->request->get('username') . " déjà utilisé"));

        return $app->redirect('/signup');
    }

    //save the user in the database
    $app['dao.user']->setUser($request->request->get('user_login'), $request->request->get('user_password'));
    $user = $app['dao.user']->findByUserLogin($request->request->get('user_login'));

    //set the session
    $app['session']->set('user', $user);
    $app['session']->set('connected', array('connected' => true));

    return $app['twig']->render('index.html.twig');
})->bind('signup_check');

$app->post('/signup_check_username', function (Request $request) use ($app) {
    return $app['dao.user']->usernameIsFree($request->request->get('user_login'));
})->bind('signup_check_username');

$app->post('/newquiz_check', function (Request $request) use ($app) {
    $title = htmlspecialchars($request->request->get('quiz_title'));
    if (!$app['dao.quiz']->titleIsFree($title)) {
        $app['session']->getFlashBag()->add('message'
            , array('type' => 'danger', 'content' => 'Le titre "' . $title . '" est déjà pris'));

        return $app->redirect('/new/quiz');
    }
    $description = htmlspecialchars($request->request->get('quiz_description'));
    $quizId = $app['dao.quiz']->saveQuiz($title, $description, $app['session']->get('user')->getUserId());
    $quiz = $app['dao.quiz']->find($quizId);

    return $app['twig']->render('formAnswer.html.twig', array('quiz' => $quiz));
})->bind('newquiz_check');

$app->post('/newAnswer_check/{id}', function (Request $request, $id) use ($app) {
    $question_content = htmlspecialchars($request->request->get('question_text'));
    $answer1 = $request->request->get('answer1_content');
    $answer2 = $request->request->get('answer2_content');
    $answer3 = $request->request->get('answer3_content');
    $answer4 = $request->request->get('answer4_content');
    $idQuestion = $app['dao.question']->saveQuestion($question_content, $request->request->get('answer_is_good'));
    $idAnswer1 = $app['dao.answer']->saveAnswer($answer1);
    $app['dao.question']->addAnswer($idQuestion, $idAnswer1);
    $idAnswer2 = $app['dao.answer']->saveAnswer($answer2);
    $app['dao.question']->addAnswer($idQuestion, $idAnswer2);
    $idAnswer3 = $app['dao.answer']->saveAnswer($answer3);
    $app['dao.question']->addAnswer($idQuestion, $idAnswer3);
    $idAnswer4 = $app['dao.answer']->saveAnswer($answer4);
    $app['dao.question']->addAnswer($idQuestion, $idAnswer4);
    $app['dao.quiz']->addQuestion($idQuestion, $id);

    $quiz = $app['dao.quiz']->find($id);
    $questions_id = $app['dao.quiz']->getQuestionByQuiz($id);
    $questions = array();
    foreach ($questions_id as $question_id) {
        $question = $app['dao.question']->find($question_id);
        if ($question != null) {
            array_push($questions, $question);
        }
    }

    if ($request->request->get('finish')) {
        $quizzes = $app['dao.quiz']->findAll();

        return $app['twig']->render('index.html.twig', array('quizzes' => $quizzes));
    }

    return $app['twig']->render('formAnswer.html.twig', array('quiz' => $quiz, 'questions' => $questions));
})->bind('newAnswer_check');

$app->post('/edit/user/{id}/newpasswordchecker', function (Request $request, $id) use ($app) {

    // Si aucun utilisateur n'est connecté, alors on autorise rien.
    if (null === $user = $app['session']->get('user')) {
        $app['session']->getFlashBag()->add('message', array('type' => 'danger', 'content' => 'Cette opération ne vous est pas permise'));

        return $app->redirect('/login');
    }

    // On récupère les deux mots de passe.
    // TODO Est il nécessaire de mettre un htmlspecialchar ici ?
    $user_password1 = $request->request->get('user_password1');
    $user_password2 = $request->request->get('user_password2');

    // Si le mot de passe et sa vérification sont différents, alors on quitte le script
    if ($user_password1 !== $user_password2) {
        $app['session']->getFlashBag()->add('message', array('content' => 'Les mots de passe saisis ne correspondant pas', 'type' => 'warning'));

        return $app->redirect($app['url_generator']->generate('edituser', array('id' => $id)));
    }

    // Si l'utilisateur est admin, alors il peut changer le mot de passe d'un utilisateur.
    if ($app['function.isAdmin']) {
        $app['dao.user']->updatePassword($user_password1, $id);
        $app['session']->getFlashBag()->add('message', array('content' => 'Le mot de passe de l\'utilisateur a bien
        été modifié', 'type' => 'success'));

        return $app->redirect($app['url_generator']->generate('admin'));
    }

    // Si l'utilisateur à supprimer est l'utilisateur actuel, on autorise la suppression.
    if ($user->getUserId() === $id) {
        $app['dao.user']->updatePassword($user_password1, $id);
        $app['session']->getFlashBag()->add('message', array('content' => 'Votre mot de passe a bien été modifié', 'type' => 'success'));

        return $app->redirect($app['url_generator']->generate('home'));
    }

    $app['session']->getFlashBag()->add('message', array('content' => 'Vous n\'êtes pas autorisé à effectuer cette
    action', 'type' => 'warning'));

    return $app->redirect($app['url_generator']->generate('home'), 303); // 303 See Other
})->bind('newpasswordchecker');