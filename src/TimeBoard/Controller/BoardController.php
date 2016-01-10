<?php
namespace TimeBoard\Controller;

use Symfony\Component\HttpFoundation\Response;
use TimeBoard\Manager\UserManager;
use Twig_Environment;

/**
 * Class BaseController
 * @package TimeBoard\Controller
 */
class BoardController {

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * BoardController constructor.
     * @param UserManager $userManager
     * @param Twig_Environment $twig
     */
    public function __construct(UserManager $userManager, Twig_Environment $twig)
    {
        $this->userManager = $userManager;
        $this->twig = $twig;
    }


    public function renderTimeBoardIndex($dateId)
    {
        $date = new DateTime($dateId);
        return $this->twig->render('Board/index.html.twig', array('date' => $date->format('Y-m-d'), ));
    }

    public function renderTimeBoardEdit($dateId)
    {
        $date = new DateTime($dateId);
        // do db query get date or something
        return $this->twig->render('Board/edit.html.twig', array('date' => $date->format('Y-m-d'), ));
    }
}
