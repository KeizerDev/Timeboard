<?php

namespace TimeBoard\Model;

class Course
{

    /**
     * Course id
     * @var INT
     */
    protected $id;


    /**
     * Course name
     * @var String
     */
    protected $courseName;

    /**
     * @return INT
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param INT $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return String
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * @param String $courseName
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;
    }

}