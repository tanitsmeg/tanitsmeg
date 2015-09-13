<?php

namespace DN\TMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class SEOEntity {

    /**
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    protected $seoTitle;

    /**
     * @ORM\Column(name="seo_text", type="text", nullable=true)
     */
    protected $seoText;

    /**
     * @ORM\Column(name="canonical_url", type="string", length=255, nullable=true)
     */
    protected $canonicalUrl;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $noindex;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $noarchive;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $nofollow;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $noydir;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $noopd;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $nosnippet;

    public function getSeoTitle() {
        return $this->seoTitle;
    }

    public function getSeoText() {
        return $this->seoText;
    }

    public function getCanonicalUrl() {
        return $this->canonicalUrl;
    }

    public function getNoindex() {
        return $this->noindex;
    }

    public function getNoarchive() {
        return $this->noarchive;
    }

    public function getNofollow() {
        return $this->nofollow;
    }

    public function getNoydir() {
        return $this->noydir;
    }

    public function getNoopd() {
        return $this->noopd;
    }

    public function getNosnippet() {
        return $this->nosnippet;
    }

    public function setSeoTitle($seoTitle) {
        $this->seoTitle = $seoTitle;
    }

    public function setSeoText($seoText) {
        $this->seoText = $seoText;
    }

    public function setCanonicalUrl($canonicalUrl) {
        $this->canonicalUrl = $canonicalUrl;
    }

    public function setNoindex($noindex) {
        $this->noindex = $noindex;
    }

    public function setNoarchive($noarchive) {
        $this->noarchive = $noarchive;
    }

    public function setNofollow($nofollow) {
        $this->nofollow = $nofollow;
    }

    public function setNoydir($noydir) {
        $this->noydir = $noydir;
    }

    public function setNoopd($noopd) {
        $this->noopd = $noopd;
    }

    public function setNosnippet($nosnippet) {
        $this->nosnippet = $nosnippet;
    }

}
