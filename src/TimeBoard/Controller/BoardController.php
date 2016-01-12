<?php
namespace TimeBoard\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TimeBoard\Manager\TimeBoardManager;
use TimeBoard\Manager\UserManager;
use TimeBoard\Model\TimeBoard;
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


    /**
     * @param $dateId
     * @return string
     */
    public function renderTimeBoardIndex($dateId)
    {
        $date = new \DateTime($dateId);

             return $this->twig->render('Board/index.html.twig', [
            'date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ),
            'accountability' => $this->boardManager->getTimeBoardRepository()->getTimeBoardOfDate($date)]
            );
    }

    /**
     * @param $dateId
     * @return string
     */
    public function renderTimeBoardEdit($dateId)
    {
        $date = new \DateTime($dateId);
        return $this->twig->render('Board/edit.html.twig',[
            'date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ),
            'vakken' => $this->boardManager->getTimeBoardRepository()->getAllCourses(),
            'accountability' => $this->boardManager->getTimeBoardRepository()->getTimeBoardOfDate($date)
        ]);
    }


    /**
     * @param $dateId
     * @return string
     */
    public function renderTimeBoardNew($dateId)
    {
        $date = new \DateTime($dateId);
        return $this->twig->render('Board/new.html.twig', [
            'date' => array('date_today' => $date->format('d-m-Y'), 'date_prev' => Date("d-m-Y", strtotime("$dateId -1 Day")), 'date_next' => Date("d-m-Y", strtotime("$dateId +1 Day")), ),
            'vakken' => $this->boardManager->getTimeBoardRepository()->getAllCourses(),
        ]);
    }


    public function handleNewTimeBoard(Request $request, $dateId)
    {
        $course = $request->get('vak');
        $minutes = intval($request->get('minutes'));
        $note = $request->get('note');
        $date = new \DateTime($dateId);


        $board = new TimeBoard();
        $board->setCourse($this->boardManager->getTimeBoardRepository()->getCourseByIdentifier($course));
        $board->setMinutes($minutes);
        $board->setNote($note);
        $board->setDate($date->getTimestamp() * 1000);
        $board->setUser($this->userManager->getCurrentUser());


        //todo: add validation to the board
        $this->boardManager->getTimeBoardRepository()->insertNewTimeBoard($board);

        return new RedirectResponse('/verantwoording/'.$dateId);
    }
}
