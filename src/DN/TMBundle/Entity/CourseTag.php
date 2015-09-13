<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_tag")
 */
class CourseTag {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Course", inversedBy="courseTags")
     * @JoinColumn(name="course_id", referencedColumnName="id")
     **/
    protected $course;

    /**
     * @ManyToOne(targetEntity="Tag")
     * @JoinColumn(name="tag_id", referencedColumnName="id")
     **/
    protected $tag;

    public function getCourse() {
        return $this->course;
    }

    public function getTag() {
        return $this->tag;
    }

    public function setCourse($course) {
        $this->course = $course;
    }

    public function setTag($tag) {
        $this->tag = $tag;
    }

}
