<?php
namespace TimeBoard\Controller;


use Twig_Environment;

class SecurityController
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * SecurityController constructor.
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }


    public function renderLoginPage()
    {
        return $this->twig->render('Security/login.html.twig');
    }

}