<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use DN\TMBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks
 */
class User {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

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
    protected $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $category;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $birthyear;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $birthyearPublic;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $gender;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description2;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $genderPublic;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $homepage;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $city;

    /**
     * @ORM\OneToMany(targetEntity="CourseOrder", mappedBy="user" )
     */
    protected $orders;

    /**
     * @ManyToMany(targetEntity="Tag")
     * @JoinTable(name="user_favorite_tags",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    protected $favoriteTags;

    /**
     * @ManyToMany(targetEntity="Course")
     * @JoinTable(name="user_favorite_courses",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="course_id", referencedColumnName="id")}
     *      )
     */
    protected $favoriteCourses;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    public function getId() {
        return $this->id;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getCategory() {
        return $this->category;
    }

    public function getBirthyear() {
        return $this->birthyear;
    }

    public function getBirthyearPublic() {
        return $this->birthyearPublic;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDescription2() {
        return $this->description2;
    }

    public function getGenderPublic() {
        return $this->genderPublic;
    }

    public function getHomepage() {
        return $this->homepage;
    }

    public function getCity() {
        return $this->city;
    }

    public function getOrders() {
        return $this->orders;
    }

    public function getFavoriteTags() {
        return $this->favoriteTags;
    }

    public function getFavoriteCourses() {
        return $this->favoriteCourses;
    }

    public function getActive() {
        return $this->active;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function setCategory($category) {
        $this->category = $category;
    }

    public function setBirthyear($birthyear) {
        $this->birthyear = $birthyear;
    }

    public function setBirthyearPublic($birthyearPublic) {
        $this->birthyearPublic = $birthyearPublic;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDescription2($description2) {
        $this->description2 = $description2;
    }

    public function setGenderPublic($genderPublic) {
        $this->genderPublic = $genderPublic;
    }

    public function setHomepage($homepage) {
        $this->homepage = $homepage;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setOrders($orders) {
        $this->orders = $orders;
    }

    public function setFavoriteTags($favoriteTags) {
        $this->favoriteTags = $favoriteTags;
    }

    public function setFavoriteCourses($favoriteCourses) {
        $this->favoriteCourses = $favoriteCourses;
    }

    public function setActive($active) {
        $this->active = $active;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
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
