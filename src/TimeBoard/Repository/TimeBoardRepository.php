<?php
namespace TimeBoard\Repository;

use Doctrine\DBAL\Connection;
use Symfony\Component\Validator\Constraints\Date;
use TimeBoard\Model\Course;
use TimeBoard\Model\User;

class TimeBoardRepository
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
        }

        return null;
    }


    public function getCourseByIdentifier($id)
    {
        $sql = "SELECT * FROM vakken WHERE id=:id";

        $params = [
            'id' => $id
        ];

        $data = $this->conn->fetchArray($sql, $params);

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
     * @return null|Date
     */
    public function getTimeboardOfDate($dateOfBoard)
    {
        //WHAT THE FUCK IS THIS!!!! INLINE FUCKING QUERYS!!! NO DATABINDING?????? NOOOB RJ!!
        $sql = "SELECT * FROM accountability WHERE datum=:datum";

        $params = [
          "datum" => $dateOfBoard
        ];

        $data = $this->conn->fetchAll($sql, $params);

        if($data) {
            return $data;
        }
        return null;
    }


    /**
     * @param array $timeBoardData
     */
    private function hydrateTimeBoard(array $timeBoardData)
    {

    }

}