<?php

use TimeBoard\Controller\BaseController;
use TimeBoard\Controller\BoardController;
use TimeBoard\Controller\PlanningController;
use TimeBoard\Controller\SecurityController;
use TimeBoard\Fixtures;
use TimeBoard\Manager\TimeBoardManager;
use TimeBoard\Manager\UserManager;
use TimeBoard\Repository\TimeBoardRepository;
use TimeBoard\Repository\UserRepository;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());

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
    )
));


$app['UserManager'] = $app->share(function() use ($app) {
    return new UserManager($app['UserRepository'], $app);
});

$app['TimeBoardManager'] = $app->share(function() use ($app) {
    return new TimeBoardManager($app['TimeBoardRepository']);
});

$app['UserRepository'] = $app->share(function() use ($app) {
    return new UserRepository($app['db']);
});

$app['TimeBoardRepository'] = $app->share(function() use ($app) {
    return new TimeBoardRepository($app['db'], $app['UserManager']);
});

$app['BaseController'] = $app->share(function() use ($app) {
    return new BaseController($app['twig']);
});

$app['BoardController'] = $app->share(function() use ($app) {
    return new BoardController($app['UserManager'], $app['TimeBoardManager'], $app['twig']);
});

$app['PlanningController'] = $app->share(function() use ($app) {
    return new PlanningController($app['UserManager'], $app['TimeBoardManager'], $app['twig']);
});

$app['SecurityController'] = $app->share(function() use ($app) {
    return new SecurityController($app['twig'], $app['UserManager']);
});


/* twig service provider */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/TimeBoard/Resources/view',
));


$app->get('/', 'BaseController:renderMainPage');
$app->get('/login', 'SecurityController:renderLoginPage');
$app->get('/planning/{dateId}', 'PlanningController:renderPlanning')->bind('');
$app->get('/verantwoording/{dateId}', 'BoardController:renderTimeBoardIndex')->bind('');
$app->get('/verantwoording/{dateId}/edit', 'BoardController:renderTimeBoardEdit');
$app->get('/verantwoording/{dateId}/new', 'BoardController:renderTimeBoardNew')->bind('newTimeBoard');
$app->post('/verantwoording/{dateId}/new_post', 'BoardController:handleNewTimeBoard')->bind('newTimeBoard_post');


if($app['debug'] == true) {
    $app['Fixtures'] = $app->share(function() use ($app) {
        return new Fixtures($app['UserRepository'], $app['TimeBoardRepository']);
    });

    $app->get('/setup', 'Fixtures:createStructure');
}

$app->run();
