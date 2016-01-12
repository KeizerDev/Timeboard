<?php
namespace TimeBoard\Controller;


use TimeBoard\Manager\UserManager;
use Twig_Environment;

class SecurityController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * SecurityController constructor.
     * @param Twig_Environment $twig
     * @param UserManager $userManager
     */
    public function __construct(Twig_Environment $twig, UserManager $userManager)
    {
        $this->twig = $twig;
        $this->userManager = $userManager;
    }

    public function renderLoginPage()
    {
       // $this->registerUser();
        return $this->twig->render('Security/login.html.twig');
    }


    public function registerUser()
    {
        $user = $this->userManager->createUser([
            'username' => 'root',
            'password' => 'root'
        ]);

        $this->userManager->getUserRepository()->insertNewUser($user);
    }

}