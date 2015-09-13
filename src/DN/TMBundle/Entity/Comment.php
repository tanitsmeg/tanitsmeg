<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CommentRepository")
 * @ORM\Table(name="comment")
 */
class Comment {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $entityType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $entityId;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $entitySlug;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $created;

    public function getId() {
        return $this->id;
    }

    public function getUser() {
        return $this->user;
    }

    public function getContent() {
        return $this->content;
    }

    public function getEntityType() {
        return $this->entityType;
    }

    public function getEntityId() {
        return $this->entityId;
    }

    public function getEntitySlug() {
        return $this->entitySlug;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setEntityType($entityType) {
        $this->entityType = $entityType;
    }

    public function setEntityId($entityId) {
        $this->entityId = $entityId;
    }

    public function setEntitySlug($entitySlug) {
        $this->entitySlug = $entitySlug;
    }

    public function setCreated($created) {
        $this->created = $created;
    }

}
