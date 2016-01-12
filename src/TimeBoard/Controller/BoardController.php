<?php
namespace TimeBoard\Controller;

use Symfony\Component\HttpFoundation\Response;
use TimeBoard\Manager\TimeBoardManager;
use TimeBoard\Manager\UserManager;
use TimeBoard\Repository\TimeBoardRepository;
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
     * @var TimeBoardManager
     */
    private $boardManager;

    /**
     * BoardController constructor.
     * @param UserManager $userManager
     * @param TimeBoardManager $boardManager
     * @param Twig_Environment $twig
     */
    public function __construct(UserManager $userManager, TimeBoardManager $boardManager, Twig_Environment $twig)
    {
        $this->userManager = $userManager;
        $this->twig = $twig;
        $this->boardManager = $boardManager;
    }


    public function renderTimeBoardIndex($dateId)
    {
        $date = new \DateTime($dateId);

             return $this->twig->render('Board/index.html.twig', [
            'date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ),
            'accountability' => $this->boardManager->getTimeBoardRepository()->getTimeBoardOfDate($date)]
            );
    }

    public function renderTimeBoardEdit($dateId)
    {
        $date = new \DateTime($dateId);
        return $this->twig->render('Board/edit.html.twig',[
            'date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ),
            'vakken' => $this->boardManager->getTimeBoardRepository()->getAllCourses(),
            'accountability' => $this->boardManager->getTimeBoardRepository()->getTimeBoardOfDate($date)
        ]);
    }
}
