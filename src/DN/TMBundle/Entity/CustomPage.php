<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CustomPageRepository")
 * @ORM\Table(name="custom_page")
 */
class CustomPage extends SEOEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $subtitle;

    /**
     * @ORM\Column(name="teaser_text", type="text", nullable=true)
     */
    protected $teaserText;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(name="teaser_image", referencedColumnName="id")
     */
    protected $teaserImage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $active;

    public function __toString() {
        return $this->title;
    }

    public function getId() {
        return $this->id;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSubtitle() {
        return $this->subtitle;
    }

    public function getTeaserText() {
        return $this->teaserText;
    }

    public function getTeaserImage() {
        return $this->teaserImage;
    }

    public function getContent() {
        return $this->content;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getUpdated() {
        return $this->updated;
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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSubtitle($subtitle) {
        $this->subtitle = $subtitle;
    }

    public function setTeaserText($teaserText) {
        $this->teaserText = $teaserText;
    }

    public function setTeaserImage($teaserImage) {
        $this->teaserImage = $teaserImage;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setCreated(\DateTime $created) {
        $this->created = $created;
    }

    public function setUpdated(\DateTime $updated) {
        $this->updated = $updated;
    }

    public function setActive($active) {
        $this->active = $active;
    }

}
