<?php

namespace TimeBoard;

use Symfony\Component\HttpFoundation\Response;
use TimeBoard\Repository\UserRepository;

/**
 * Class Fixtures
 * @package TimeBoard
 */
class Fixtures
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @return Response
     */
    public function createStructure()
    {
        $this->userRepository->createStructure();
        return new Response("DONE");
    }



}