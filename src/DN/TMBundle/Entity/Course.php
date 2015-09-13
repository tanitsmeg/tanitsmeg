<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use DN\TMBundle\Entity\CourseTag;
use DN\TMBundle\Entity\Tag;
use DN\TMBundle\Entity\CourseTime;
use DN\TMBundle\Entity\Document;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CourseRepository")
 * @ORM\Table(name="course")
 * @ORM\HasLifecycleCallbacks
 */
class Course extends SEOEntity {

    public function __construct() {
        $this->courseTimes = new ArrayCollection();
        $this->courseTags = new ArrayCollection();
    }

    public function addCourseTime(CourseTime $courseTime) {
        $this->courseTimes->add($courseTime);
    }

    public function removeCourseTime(CourseTime $courseTime) {
        $this->courseTimes->removeElement($courseTime);
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $subtitle;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", unique=true)
     */
    protected $slug;

//    /**
//     * @OneToOne(targetEntity="Document")
//     * @JoinColumn(name="image_id", referencedColumnName="id")
//     * */
//    protected $image;

    /**
     * @ORM\OneToMany(targetEntity="CourseOrder", mappedBy="course" )
     */
    protected $orders;

    /**
     * @OneToMany(targetEntity="CourseTime", mappedBy="course", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     * */
    protected $courseTimes;

    /**
     * @ORM\Column(name="address_zip", type="string", nullable=true)
     */
    protected $addressZip;

    /**
     * @ORM\Column(name="address_city", type="string", nullable=true)
     */
    protected $addressCity;

    /**
     * @ORM\Column(name="address_street", type="string", nullable=true)
     */
    protected $addressStreet;

    /**
     * @ORM\Column(name="address_comment", type="text", nullable=true)
     */
    protected $addressComment;

    /**
     * @ORM\Column(name="to_date", type="datetime", nullable=true)
     */
    protected $toDate;

    /**
     * @ORM\Column(name="from_date", type="datetime", nullable=true)
     */
    protected $fromDate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description3;

    /**
     * @OneToMany(targetEntity="CourseTag", mappedBy="course", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     * */
    private $courseTags;

    /**
     * @ORM\Column(name="minimum_participant", type="integer", nullable=true)
     */
    protected $minParticipant;

    /**
     * @ORM\Column(name="maximum_participant", type="integer", nullable=true)
     */
    protected $maxParticipant;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="string", name="price_type", nullable=true)
     */
    protected $priceType;

    /**
     * @ORM\Column(name="discount_group", type="boolean", nullable=true)
     */
    protected $discountGroupActive;

    /**
     * @ORM\Column(name="discount_group_min_participant", type="integer", nullable=true)
     */
    protected $discountGroupMinParticipant;

    /**
     * @ORM\Column(name="discount_group_price", type="integer", nullable=true)
     */
    protected $discountGroupPrice;

    /**
     * @ORM\Column(name="discount_earlybird", type="boolean", nullable=true)
     */
    protected $discountEarlybirdActive;

    /**
     * @ORM\Column(name="discount_earlybird_date", type="datetime", nullable=true)
     */
    protected $discountEarlybirdDate;

    /**
     * @ORM\Column(name="pay_personal", type="boolean", nullable=true)
     */
    protected $payPersonal;

    /**
     * @ORM\Column(name="pay_bank", type="boolean", nullable=true)
     */
    protected $payBank;

    /**
     * @ORM\Column(name="pay_bank_name", type="string", nullable=true)
     */
    protected $payBankName;

    /**
     * @ORM\Column(name="pay_bank_account_number", type="string", nullable=true)
     */
    protected $payBankAccountNumber;

    /**
     * @ORM\Column(name="pay_bank_comment", type="string", nullable=true)
     */
    protected $payBankComment;

    /**
     * @ORM\Column(name="pay_bank_deadline", type="integer", nullable=true)
     */
    protected $payBankDeadline;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $wheelchair;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $pet;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updated;

    public function getCourseTags() {
        return $this->courseTags->toArray();
    }

    public function addCourseTag(CourseTag $courseTag) {
        if (!$this->courseTags->contains($courseTag)) {
            $this->courseTags->add($courseTag);
//            $courseTag->setCourse($this);
        }

        return $this;
    }

    public function removeCourseTag(CourseTag $courseTag) {
        if ($this->courseTags->contains($courseTag)) {
            $this->courseTags->removeElement($courseTag);
//            $tag->setPerson(null);
        }

        return $this;
    }

    public function getTags() {
        return array_map(
                function ($courseTag) {
            return $courseTag->getTag();
        }, $this->courseTags->toArray()
        );
    }

    public function __toString() {
        return $this->title;
    }

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSubtitle() {
        return $this->subtitle;
    }

    public function getSlug() {
        return $this->slug;
    }

//    public function getImage() {
//        return $this->image;
//    }
//
    public function getOrders() {
        return $this->orders;
    }

    public function getCourseTimes() {
        return $this->courseTimes;
    }

    public function getAddressZip() {
        return $this->addressZip;
    }

    public function getAddressCity() {
        return $this->addressCity;
    }

    public function getAddressStreet() {
        return $this->addressStreet;
    }

    public function getToDate() {
        return $this->toDate;
    }

    public function getFromDate() {
        return $this->fromDate;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDescription2() {
        return $this->description2;
    }

    public function getDescription3() {
        return $this->description3;
    }

    public function getMinParticipant() {
        return $this->minParticipant;
    }

    public function getMaxParticipant() {
        return $this->maxParticipant;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPriceType() {
        return $this->priceType;
    }

    public function getDiscountGroupActive() {
        return $this->discountGroupActive;
    }

    public function getDiscountGroupMinParticipant() {
        return $this->discountGroupMinParticipant;
    }

    public function getDiscountGroupPrice() {
        return $this->discountGroupPrice;
    }

    public function getDiscountEarlybirdActive() {
        return $this->discountEarlybirdActive;
    }

    public function getDiscountEarlybirdDate() {
        return $this->discountEarlybirdDate;
    }

    public function getPayPersonal() {
        return $this->payPersonal;
    }

    public function getPayBank() {
        return $this->payBank;
    }

    public function getPayBankName() {
        return $this->payBankName;
    }

    public function getPayBankAccountNumber() {
        return $this->payBankAccountNumber;
    }

    public function getPayBankComment() {
        return $this->payBankComment;
    }

    public function getPayBankDeadline() {
        return $this->payBankDeadline;
    }

    public function getWheelchair() {
        return $this->wheelchair;
    }

    public function getPet() {
        return $this->pet;
    }

    public function getActive() {
        return $this->active;
    }

    public function getUser() {
        return $this->user;
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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

//    public function setImage($image) {
//        $this->image = $image;
//    }
//
    public function setOrders($orders) {
        $this->orders = $orders;
    }

    public function setCourseTimes($courseTimes) {
        $this->courseTimes = $courseTimes;
    }

    public function setAddressZip($addressZip) {
        $this->addressZip = $addressZip;
    }

    public function setAddressCity($addressCity) {
        $this->addressCity = $addressCity;
    }

    public function setAddressStreet($addressStreet) {
        $this->addressStreet = $addressStreet;
    }

    public function setToDate($toDate) {
        $this->toDate = $toDate;
    }

    public function setFromDate($fromDate) {
        $this->fromDate = $fromDate;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDescription2($description2) {
        $this->description2 = $description2;
    }

    public function setDescription3($description3) {
        $this->description3 = $description3;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

    public function setMinParticipant($minParticipant) {
        $this->minParticipant = $minParticipant;
    }

    public function setMaxParticipant($maxParticipant) {
        $this->maxParticipant = $maxParticipant;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setPriceType($priceType) {
        $this->priceType = $priceType;
    }

    public function setDiscountGroupActive($discountGroupActive) {
        $this->discountGroupActive = $discountGroupActive;
    }

    public function setDiscountGroupMinParticipant($discountGroupMinParticipant) {
        $this->discountGroupMinParticipant = $discountGroupMinParticipant;
    }

    public function setDiscountGroupPrice($discountGroupPrice) {
        $this->discountGroupPrice = $discountGroupPrice;
    }

    public function setDiscountEarlybirdActive($discountEarlybirdActive) {
        $this->discountEarlybirdActive = $discountEarlybirdActive;
    }

    public function setDiscountEarlybirdDate($discountEarlybirdDate) {
        $this->discountEarlybirdDate = $discountEarlybirdDate;
    }

    public function setPayPersonal($payPersonal) {
        $this->payPersonal = $payPersonal;
    }

    public function setPayBank($payBank) {
        $this->payBank = $payBank;
    }

    public function setPayBankName($payBankName) {
        $this->payBankName = $payBankName;
    }

    public function setPayBankAccountNumber($payBankAccountNumber) {
        $this->payBankAccountNumber = $payBankAccountNumber;
    }

    public function setPayBankComment($payBankComment) {
        $this->payBankComment = $payBankComment;
    }

    public function setPayBankDeadline($payBankDeadline) {
        $this->payBankDeadline = $payBankDeadline;
    }

    public function setWheelchair($wheelchair) {
        $this->wheelchair = $wheelchair;
    }

    public function setPet($pet) {
        $this->pet = $pet;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function setUpdated($updated) {
        $this->updated = $updated;
    }

    public function getAddressComment() {
        return $this->addressComment;
    }

    public function setAddressComment($addressComment) {
        $this->addressComment = $addressComment;
    }

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    public $imagePath;
    private $temp;

    public function getAbsolutePath() {
        return null === $this->imagePath ? null : $this->getUploadRootDir() . '/' . $this->imagePath;
    }

    public function getWebPath() {
        return null === $this->imagePath ? null : $this->getUploadDir() . '/' . $this->imagePath;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }

    /**
     * @Assert\File(maxSize="3000000")
     */
    private $image;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setImage(UploadedFile $file = null) {
        $this->image = $file;
        // check if we have an old image path
        if (isset($this->imagePath)) {
            // store the old name to delete after the update
            $this->temp = $this->imagePath;
            $this->imagePath = null;
        } else {
            $this->imagePath = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->getImage()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->imagePath = $filename . '.' . $this->getImage()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        if (null === $this->getImage()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getImage()->move($this->getUploadRootDir(), $this->imagePath);

        // check if we have an old image
        if (isset($this->temp)) {
            // delete the old image
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        $this->image = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getImage() {
        return $this->image;
    }

}
