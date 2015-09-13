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
use DN\TMBundle\Entity\Location;
use DN\TMBundle\Entity\Tag;
use DN\TMBundle\Entity\CourseTime;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CourseOrderRepository")
 * @ORM\Table(name="course_order_item")
 */
class CourseOrderItem {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="CourseOrder", inversedBy="items")
     * @JoinColumn(name="course_order_id", referencedColumnName="id")
     * */
    protected $courseOrder;

    /**
     * @ManyToOne(targetEntity="CourseTime")
     * @JoinColumn(name="course_time_id", referencedColumnName="id")
     * */
    protected $courseTime;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $amount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", name="price_type", nullable=true)
     */
    protected $priceType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $wheelchair;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $pet;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    public function getId() {
        return $this->id;
    }

    public function getCourseOrder() {
        return $this->courseOrder;
    }

    public function getCourseTime() {
        return $this->courseTime;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPriceType() {
        return $this->priceType;
    }

    public function getWheelchair() {
        return $this->wheelchair;
    }

    public function getPet() {
        return $this->pet;
    }

    public function getStatus() {
        return $this->status;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getUpdated() {
        return $this->updated;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCourseOrder($courseOrder) {
        $this->courseOrder = $courseOrder;
    }

    public function setCourseTime($courseTime) {
        $this->courseTime = $courseTime;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setPriceType($priceType) {
        $this->priceType = $priceType;
    }

    public function setWheelchair($wheelchair) {
        $this->wheelchair = $wheelchair;
    }

    public function setPet($pet) {
        $this->pet = $pet;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

}
