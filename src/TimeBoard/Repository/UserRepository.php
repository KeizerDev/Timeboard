<?php
namespace TimeBoard\Repository;

use Doctrine\DBAL\Connection;
use TimeBoard\Model\User;

class UserRepository
{
    /**
     * @var Connection
     */
    private $conn;

    public function __construct(Connection $connection)
    {
        $this->conn = $connection;
    }


    public function createStructure()
    {
        $this->conn->executeQuery("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        username VARCHAR(100) UNIQUE,
        password VARCHAR(255) DEFAULT NULL,
        salt VARCHAR(255) NOT NULL DEFAULT '',
        roles VARCHAR(255) NOT NULL DEFAULT '',
        time_created INT NOT NULL DEFAULT 0);");
    }


    /**
     * gets a user by its identifier
     *
     * @param $id
     * @return null|User
     */
    public function getUserByIdentifier($id)
    {
        $sql = "SELECT * FROM users WHERE id=:id LIMIT 0,1";
        $params = [
            'id' => $id
        ];
        $data = $this->conn->fetchAll($sql, $params);
        if($data) {
            $user = $this->hydrateUser($data[0]);
            return $user;
        }
        return null;
    }
    /**
     * get a user by its username
     *
     * @param $username
     * @return null|User
     */
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username=:username LIMIT 0,1";
        $params = [
            'username' => $username
        ];

        $data = $this->conn->fetchAll($sql, $params);

        if($data) {
            $user = $this->hydrateUser($data[0]);
            return $user;
        }
        return null;
    }

    private function hydrateUser($data)
    {
        $user = new User($data['username']);
        $user->setId($data['id']);
        $user->setPassword($data['password']);
        if ($roles = explode(',', $data['roles'])) {
            $user->setRoles($roles);
        }
        $user->setSalt($data['salt']);
        $user->setTimeCreated($data['time_created']);

        return $user;
    }


    /**
     * Insert a new User instance into the database.
     *
     * @param User $user
     * @throws \Doctrine\DBAL\DBALException
     */
    public function insertNewUser(User $user)
    {
        $sql = 'INSERT INTO users
            (username
            , password
            , salt
            , roles
            , time_created )
            VALUES
            (:username
            , :password
            , :salt
            , :roles
            , :timeCreated)';

        $params = array(
            'password' => $user->getPassword(),
            'salt' => $user->getSalt(),
            'roles' => implode(',', $user->getRoles()),
            'timeCreated' => $user->getTimeCreated(),
            'username' => $user->getUsername(),
        );
        $this->conn->executeUpdate($sql, $params);
        $user->setId($this->conn->lastInsertId());
    }

   /**
     * get the timeboard by date object
     *
     * @param $date
     * @return null|Date
     */
    public function getTimeboardOfDate($dateOfBoard)
    {
        $sql = "SELECT * FROM accountability WHERE datum='$dateOfBoard'";

        $data = $this->conn->fetchAll($sql);

        if($data) {
            return $data;
        }
        return null;
    }

}