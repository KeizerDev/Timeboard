<?php
namespace TimeBoard\Controller;

use Twig_Environment;

/**
 * Class BaseController
 * @package TimeBoard\Controller
 */
class BaseController 
{

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * BaseController constructor.
     * @param Twig_Environment $twig
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }


    public function renderMainPage()
    {
        return $this->twig->render('Main/index.html.twig', array('date' => date('d-m-Y'), ));
    }

}
