<?php
namespace TimeBoard\Repository;

use Doctrine\DBAL\Connection;
use Symfony\Component\Validator\Constraints\Date;
use TimeBoard\Manager\UserManager;
use TimeBoard\Model\Course;
use TimeBoard\Model\TimeBoard;
use TimeBoard\Model\User;

class TimeBoardRepository
{
    /**
     * @var Connection
     */
    private $conn;
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * TimeBoardRepository constructor.
     * @param Connection $connection
     * @param UserManager $userManager
     */
    public function __construct(Connection $connection, UserManager $userManager)
    {
        $this->conn = $connection;
        $this->userManager = $userManager;
    }


    public function createStructure()
    {
        $this->conn->executeQuery("CREATE TABLE IF NOT EXISTS accountability (
        id INTEGER PRIMARY KEY,
        user_id INTEGER,
        vak INTEGER NOT NULL,
        minuten INTEGER NOT NULL,
        notitie VARCHAR(512) DEFAULT '',
        datum DATETIME NOT NULL );");

        $this->conn->executeQuery("CREATE TABLE IF NOT EXISTS vakken (
        id INTEGER PRIMARY KEY,
        vak VARCHAR(255) );");

    }



    public function getAllCourses()
    {
        $sql = "SELECT * FROM vakken";

        $data = $this->conn->fetchAll($sql);

        if($data) {
            $courseArray = [];
            foreach($data as $courseData) {
               $courseArray[] = $this->hydrateCourse($courseData);
            }

            return $courseArray;
        }

        return null;
    }



    public function getCourseByIdentifier($id)
    {
        $sql = "SELECT * FROM vakken WHERE id=:id";

        $params = [
            'id' => $id
        ];

        $data = $this->conn->fetchAssoc($sql, $params);

        if($data) {
            return $this->hydrateCourse($data);
        }

        return null;
    }


    private function hydrateCourse(array $courseData)
    {
        $course = new Course();

        $course->setId($courseData['id']);
        $course->setCourseName($courseData['vak']);

        return $course;
    }

    /**
     * get the timeboard by date object
     *
     * @param $dateOfBoard
     * @return null|TimeBoard[]
     */
    public function getTimeBoardOfDate(\DateTime $dateOfBoard)
    {
        $sql = "SELECT * FROM accountability WHERE datum=:datum";

        $params = [
          "datum" => $dateOfBoard->getTimestamp() * 1000
        ];

        $data = $this->conn->fetchAll($sql, $params);

        if($data) {
            $timeBoardData = [];
            foreach($data as $timeBoard) {
                $timeBoardData[] = $this->hydrateTimeBoard($timeBoard);
            }

            return $timeBoardData;
        }
        return null;
    }



    public function insertNewTimeBoard(TimeBoard $board)
    {
        $sql = 'INSERT INTO accountability
            (user_id
            , vak
            , minuten
            , notitie
            , datum)
            VALUES
            (:user_id
            , :course
            , :minutes
            , :note
            , :date )';

        $params = array(
            'user_id' => $board->getUser()->getId(),
            'course' => $board->getCourse()->getId(),
            'minutes' => $board->getMinutes(),
            'note' => $board->getNote(),
            'date' => $board->getDate()
        );

        $this->conn->executeUpdate($sql, $params);
        $board->setId($this->conn->lastInsertId());
    }


    /**
     * @param array $timeBoardData
     * @return TimeBoard
     */
    private function hydrateTimeBoard(array $timeBoardData)
    {
        $timeBoard = new TimeBoard();

        $timeBoard->setId($timeBoardData['id']);
        $timeBoard->setUser($this->userManager->getUserRepository()->getUserByIdentifier($timeBoardData['user_id']));
        $timeBoard->setCourse($this->getCourseByIdentifier($timeBoardData['vak']));
        $timeBoard->setMinutes($timeBoardData['minuten']);
        $timeBoard->setNote($timeBoardData['notitie']);
        $timeBoard->setDate($timeBoardData['datum']);

        return $timeBoard;
    }

}