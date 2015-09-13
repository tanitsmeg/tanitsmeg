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
 * @ORM\Table(name="course_order")
 */
class CourseOrder {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Course", inversedBy="orders")
     * @JoinColumn(name="course_id", referencedColumnName="id")
     * */
    protected $course;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="orders")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     * */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="CourseOrderItem", mappedBy="courseOrder" )
     */
    protected $items;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $comment;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $fullname;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", name="price_type", nullable=true)
     */
    protected $priceType;

    /**
     * @ORM\Column(name="payment_method", type="string", nullable=true)
     */
    protected $paymentMethod;

    /**
     * @ORM\Column(name="status", type="string", nullable=true)
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

    public function getCourse() {
        return $this->course;
    }

    public function getUser() {
        return $this->user;
    }

    public function getItems() {
        return $this->items;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getComment() {
        return $this->comment;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPriceType() {
        return $this->priceType;
    }

    public function getPaymentMethod() {
        return $this->paymentMethod;
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

    public function setCourse($course) {
        $this->course = $course;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setComment($comment) {
        $this->comment = $comment;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setPriceType($priceType) {
        $this->priceType = $priceType;
    }

    public function setPaymentMethod($paymentMethod) {
        $this->paymentMethod = $paymentMethod;
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
