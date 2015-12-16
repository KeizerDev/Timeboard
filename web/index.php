<?php

use TimeBoard\Manager\UserManager;
use TimeBoard\Repository\UserRepository;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();


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
        array('^/', 'ROLE_USER'),
    )
));


$app['UserManager'] = $app->share(function() use ($app) {
    return new UserManager($app['UserRepository']);
});

$app['UserRepository'] = $app->share(function() use ($app) {
    return new UserRepository($app['db']);
});


$app->get('/hello', function () {
    return 'Hello!';
});

$app->run();
