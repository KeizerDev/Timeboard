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
     *
     * Course name
     * @var String
     */
    protected $vak;

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
    public function getVak()
    {
        return $this->vak;
    }

    /**
     * @param String $vak
     */
    public function setVak($vak)
    {
        $this->vak = $vak;
    }

}