<?php
namespace TimeBoard\Repository;

use Doctrine\DBAL\Connection;

class UserRepository
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

}