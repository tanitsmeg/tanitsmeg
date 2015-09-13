<?php

namespace DN\TMBundle\Manager;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

use DN\TMBundle\Model\SiteSearch;

class SiteSearchManager {
    protected $finder;

    public function __construct(PaginatedFinderInterface $finder) {
        $this->finder = $finder;
    }

    public function search(SiteSearch $siteSearch) {
        // We create a query to return all the articles but if the criteria text is specified, we use it
        if ($siteSearch->getText() != null && $siteSearch != '') {
            $baseQuery = new \Elastica\Query\MultiMatch();
            $baseQuery->setQuery($siteSearch->getText())->setFields(array(
                'title',
                'subtitle',
                'courseContent',
                'content',
            ));
            $baseQuery->setFuzziness(0.7);
            $baseQuery->setMinimumShouldMatch('80%');
        } else {
            $baseQuery = new \Elastica\Query\MatchAll();
        }

        // Then we create filters depending on the chosen criterias

        // Filter courses only if type is not "product"
        $productTypeFilter = new \Elastica\Filter\Type();
        $productTypeFilter->setType('product');
        $productNotFilter = new \Elastica\Filter\BoolNot($productTypeFilter);

        // Filter for products with available courses
        $nestedFilter = new \Elastica\Filter\Nested();
        $nestedFilter->setPath('courses');
        $nestedFilter->setQuery( new \Elastica\Query\Range('beginDate',
            array(
                'gte' => \Elastica\Util::convertDate((new \DateTime())->getTimestamp()),
            )
        ) );

        // Filter not(products) OR products with available courses
        $orFilter = new \Elastica\Filter\BoolOr();
        $orFilter->addFilter($productNotFilter);
        $orFilter->addFilter($nestedFilter);

        // Create a bool filter to put everything together
        $boolFilter = new \Elastica\Filter\Bool();
        $boolFilter->addMust($orFilter);

        // Filter type
        if ( $siteSearch->getIsProduct() || $siteSearch->getIsInfoEvent() || $siteSearch->getIsContent() ) {
            // Create OR filter to put together the types
            $typeOrFilter = new \Elastica\Filter\BoolOr();

            // Filter products
            if ( $siteSearch->getIsProduct() ) {
                $productAndFilter =  new \Elastica\Filter\BoolAnd();
                $productAndFilter->addFilter($productTypeFilter);

                $infoFilter = new \Elastica\Filter\Term(array('infoVa' => false));
                $productAndFilter->addFilter($infoFilter);

                $typeOrFilter->addFilter($productAndFilter);
            }

            // Filter info events if isProduct is not selected
            if ( $siteSearch->getIsInfoEvent() ) {
                $productAndFilter = new \Elastica\Filter\BoolAnd();
                $productAndFilter->addFilter($productTypeFilter);

                $infoFilter = new \Elastica\Filter\Term(array('infoVa' => true));
                $productAndFilter->addFilter($infoFilter);

                $typeOrFilter->addFilter($productAndFilter);
            }

            // Filter content
            if ( $siteSearch->getIsContent() ) {
                $typeOrFilter->addFilter($productNotFilter);
            }

            $boolFilter->addMust($typeOrFilter);
        }

        // Filter product type
        if ( $siteSearch->getProductType() ) {
            $productTypeFilter = new \Elastica\Filter\Nested();
            $productTypeFilter->setPath('productType');
            $productTypeFilter->setFilter( new \Elastica\Filter\Term(array('productType._id' => $siteSearch->getProductType()->getId())) );
            $boolFilter->addMust($productTypeFilter);
        }

        // Filter day time
        if ( $siteSearch->getDayTime() ) {
            $dayTimeFilter = new \Elastica\Filter\Nested();
            $dayTimeFilter->setPath('courses');
            $dayTimeFilter->setFilter( new \Elastica\Filter\Term(array('courses.dayTimes' => $siteSearch->getDayTime())) );
            $boolFilter->addMust($dayTimeFilter);
        }

        // Filter category
        if ( $siteSearch->getCategory() ) {
            $categoryFilter = new \Elastica\Filter\BoolOr();

            $mainCategoryFilter = new \Elastica\Filter\Nested();
            $mainCategoryFilter->setPath('category');
            $mainCategoryFilter->setFilter( new \Elastica\Filter\Term(array('category._id' => $siteSearch->getCategory()->getId())) );

            $subCategoryFilter = new \Elastica\Filter\Nested();
            $subCategoryFilter->setPath('subcategory');
            $subCategoryFilter->setFilter( new \Elastica\Filter\Term(array('subcategory._id' => $siteSearch->getCategory()->getId())) );

            $additionalCategoryFilter = new \Elastica\Filter\Nested();
            $additionalCategoryFilter->setPath('additionalCategories');
            $additionalCategoryFilter->setFilter( new \Elastica\Filter\Term(array('additionalCategories._id' => $siteSearch->getCategory()->getId())) );

            $categoryFilter->addFilter($mainCategoryFilter);
            $categoryFilter->addFilter($subCategoryFilter);
            $categoryFilter->addFilter($additionalCategoryFilter);
            $boolFilter->addMust($categoryFilter);
        }

        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolFilter);

        $query = \Elastica\Query::create($filtered);
        $sort = $siteSearch->getSort();
        if ( !empty($sort) ) {
            $sort = explode(' ', $sort);
            $query->setSort(array(
                $sort[0] => array(
                    'order' => $sort[1],
                ),
                "_score" => array(
                    'order' => 'desc',
                ),
            ));
        }

        $paginated = $this->finder->findPaginated($query);
        $paginated
            ->setMaxPerPage($siteSearch->getPerPage())
            ->setCurrentPage($siteSearch->getPage())
        ;

        return $paginated;
    }
}
