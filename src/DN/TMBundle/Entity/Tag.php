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
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\TagRepository")
 * @ORM\Table(name="tag")
 */
class Tag {

    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @ORM\Id
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"all"})
     * @ORM\JoinColumn(name="icon", referencedColumnName="id")
     */
    protected $icon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $displayLevel;

    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getDisplayLevel() {
        return $this->displayLevel;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setIcon($icon) {
        $this->icon = $icon;
    }

    public function setDisplayLevel($displayLevel) {
        $this->displayLevel = $displayLevel;
    }

}
