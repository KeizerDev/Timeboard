<?php

use TimeBoard\Controller\BoardController;
use TimeBoard\Controller\SecurityController;
use TimeBoard\Manager\UserManager;
use TimeBoard\Repository\UserRepository;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_sqlite',
        'path'     => __DIR__.'/../data/app.db',
    ),
));

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'login_path' => array(
            'pattern' => '^/login$',
            'anonymous' => true
        ),
        'default' => array(
            'pattern' => '^/.*$',
            'anonymous' => true,
            'form' => array(
                'login_path' => '/login',
                'check_path' => '/login_check',
            ),
            'logout' => array(
                'logout_path' => '/logout',
            ),
            'users' => $app->share(function($app) {
                return $app['UserManager'];
            }),
        )
    ),
    'security.access_rules' => array(
        array('^/login', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/register', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/setup', 'IS_AUTHENTICATED_ANONYMOUSLY'),
        array('^/', 'ROLE_USER'),
        array('^/verantwoording', 'ROLE_USER'),
    )
));


$app['UserManager'] = $app->share(function() use ($app) {
    return new UserManager($app['UserRepository'], $app);
});

$app['UserRepository'] = $app->share(function() use ($app) {
    return new UserRepository($app['db']);
});


$app['BoardController'] = $app->share(function() use ($app) {
    return new BoardController($app['UserManager'], $app['twig']);
});


$app['SecurityController'] = $app->share(function() use ($app) {
    return new SecurityController($app['twig']);
});

/* twig service provider */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/TimeBoard/Resources/view',
));



$app->get('/', 'BoardController:renderTimeBoardIndex');
$app->get('/login', 'SecurityController:renderLoginPage');

$app->get('/verantwoording/{id}', 'BoardController:renderTimeBoardIndex');
$app->get('/verantwoording/{id}/edit', 'BoardController:renderTimeBoardEdit');



if($app['debug'] == true) {

    $app['Fixtures'] = $app->share(function() use ($app) {
        return new \TimeBoard\Fixtures($app['UserRepository']);
    });

    $app->get('/setup', 'Fixtures:createStructure');
}

$app->run();
