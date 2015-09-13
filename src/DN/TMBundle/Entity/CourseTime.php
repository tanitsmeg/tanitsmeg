<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_time")
 */
class CourseTime {

    /**
     * @ORM\Id
     * @GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Course")
     * @JoinColumn(name="course", referencedColumnName="id")
     */
    protected $course;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="date_from", type="datetime", nullable=true)
     */
    protected $from;

    /**
     * @ORM\Column(name="date_to", type="datetime", nullable=true)
     */
    protected $to;

    public function getId() {
        return $this->id;
    }

    public function getCourse() {
        return $this->course;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getFrom() {
        return $this->from;
    }

    public function getTo() {
        return $this->to;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCourse($course) {
        $this->course = $course;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setTo($to) {
        $this->to = $to;
    }

}
