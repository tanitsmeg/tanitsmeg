<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\LocationRepository")
 * @ORM\Table(name="location")
 */
class Location {

    public function __construct() {
//        $this->courses = new ArrayCollection();
    }

//    public function addCourse(Course $course) {
//        if (!$this->courses->contains($course)) {
//            $this->courses->add($course);
//        }
//    }
//
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $street;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

//    /**
//     * @ManyToMany(targetEntity="Course", mappedBy="locations")
//     **/
//    protected $courses;
//    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getCity() {
        return $this->city;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
//    public function getCourses() {
//        return $this->courses;
//    }
//
//    public function setCourses($courses) {
//        $this->courses = $courses;
//    }
//
}
