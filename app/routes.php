<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 11/17/15
 * Time: 5:10 PM
 */
$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
});