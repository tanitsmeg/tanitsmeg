<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CourseStatsRepository")
 * @ORM\Table(name="course_stats")
 */
class CourseStats extends SEOEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="string", length=32)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

}
