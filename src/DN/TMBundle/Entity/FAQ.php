<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass="DN\TMBundle\Entity\FAQRepository")
 * @ORM\Table(name="faq")
 */
class FAQ extends SEOEntity {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $question;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $answer;

    /**
     * @ManyToOne(targetEntity="FAQCategory")
     * @JoinColumn(name="faq_category", referencedColumnName="id")
     */
    protected $faqCategory;

    public function __toString() {
        return $this->question;
    }

    public function getId() {
        return $this->id;
    }

    public function getSlug() {
        return $this->slug;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getFaqCategory() {
        return $this->faqCategory;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setSlug($slug) {
        $this->slug = $slug;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function setFaqCategory($faqCategory) {
        $this->faqCategory = $faqCategory;
    }

}
