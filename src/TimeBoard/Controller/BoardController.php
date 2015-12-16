<?php
namespace TimeBoard\Controller;

use Symfony\Component\HttpFoundation\Response;
use TimeBoard\Manager\UserManager;

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
     * BoardController constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }




}
