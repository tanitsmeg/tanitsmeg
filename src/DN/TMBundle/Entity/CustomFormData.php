<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\CustomFormDataRepository")
 * @ORM\Table(name="custom_form_data")
 */
class CustomFormData {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="form_type", type="string", length=100, nullable=true)
     */
    protected $formType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $data;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $email;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    public function getId() {
        return $this->id;
    }

    public function getFormType() {
        return $this->formType;
    }

    public function getData() {
        return $this->data;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFormType($formType) {
        $this->formType = $formType;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCreated(\DateTime $created) {
        $this->created = $created;
    }

}
