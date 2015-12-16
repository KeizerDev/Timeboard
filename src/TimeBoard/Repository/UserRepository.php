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


    public function createStructure()
    {
        $this->connection->executeQuery("CREATE TABLE users (
        id INTEGER PRIMARY KEY,
        username VARCHAR(100) UNIQUE,
        password VARCHAR(255) DEFAULT NULL,
        salt VARCHAR(255) NOT NULL DEFAULT '',
        roles VARCHAR(255) NOT NULL DEFAULT '',
        time_created INT NOT NULL DEFAULT 0)");
    }


}