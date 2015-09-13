<?php

namespace DN\TMBundle\Model;

class CategorySearch {
    // a public array to be used as choices list in the form
    public static $sortChoices = array(
        'rating asc' => 'Rating',
        'title.raw asc' => 'A-Z',
        'title.raw desc' => 'Z-A',
        'courses.price asc' => 'Price asc',
        'courses.price desc' => 'Price desc',
    );

    // Tells if the search result should be a Product
    protected $isProduct;

    // Tells if the search result should be an Info Event
    protected $isInfoEvent;

    // The ProductType (seminar, diplomlehrgang, etc)
    protected $productType;

    // The time of the Product Course (evening, weekend, etc)
    protected $dayTime;

    //The subcategories to filter the Product by
    protected $subcategories;

    // define the default field used for the sorting
    protected $sort;

    // the default page number
    protected $page = 1;

    // the default number of items per page
    protected $perPage = 20;




    public function getSubcategories() {
        return $this->subcategories;
    }

    public function setSubcategories($subcategories) {
        $this->subcategories = $subcategories;
        return $this;
    }

    public function getDayTime() {
        return $this->dayTime;
    }

    public function setDayTime($dayTime) {
        $this->dayTime = $dayTime;
        return $this;
    }

    public function getIsInfoEvent() {
        return $this->isInfoEvent;
    }

    public function setIsInfoEvent($isInfoEvent) {
        $this->isInfoEvent = $isInfoEvent;
        return $this;
    }

    public function getIsProduct() {
        return $this->isProduct;
    }

    public function setIsProduct($isProduct) {
        $this->isProduct = $isProduct;
        return $this;
    }

    public function getProductType() {
        return $this->productType;
    }

    public function setProductType($productType) {
        $this->productType = $productType;
        return $this;
    }

    public function getSort() {
        return $this->sort;
    }

    public function setSort($sort) {
        $this->sort = $sort;
        return $this;
    }

    public function getPage() {
        return $this->page;
    }

    public function setPage($page) {
        $this->page = $page;
        return $this;
    }

    public function getPerPage() {
        return $this->perPage;
    }

    public function setPerPage($perPage) {
        $this->perPage = $perPage;
        return $this;
    }

}
