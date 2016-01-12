<?php
namespace TimeBoard\Controller;

// use \DateTime as SQLite3;
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
        $date = new \DateTime($dateId);
        // return print_r($this->userManager->getUserRepository()->getTimeboardOfDate($date->format('d-m-Y')));    
        return $this->twig->render('Board/index.html.twig', array('date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ), 'accountability' => $this->userManager->getUserRepository()->getTimeboardOfDate($date->format('d-m-Y')), ));
    }

    public function renderTimeBoardEdit($dateId)
    {
        $date = new \DateTime($dateId);
        return $this->twig->render('Board/edit.html.twig',array('date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ), 'vakken' => $this->userManager->getUserRepository()->conn->fetchAll('SELECT * FROM vakken'), ));
    }
}
