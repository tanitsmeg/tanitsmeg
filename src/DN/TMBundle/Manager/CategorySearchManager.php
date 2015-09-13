<?php

namespace DN\TMBundle\Manager;

use FOS\ElasticaBundle\Finder\PaginatedFinderInterface;

use DN\TMBundle\Model\CategorySearch,
    DN\TMBundle\Entity\Category;

class CategorySearchManager {
    protected $finder;

    public function __construct(PaginatedFinderInterface $finder) {
        $this->finder = $finder;
    }

    public function search(Category $currentCategory, CategorySearch $categorySearch) {
        // We create a query to return all the products
        $baseQuery = new \Elastica\Query\MatchAll();

        // Then we create filters depending on the chosen criterias

        // Filter products
        $productTypeFilter = new \Elastica\Filter\Type();
        $productTypeFilter->setType('product');

        // Filter for products with available courses
        $nestedFilter = new \Elastica\Filter\Nested();
        $nestedFilter->setPath('courses');
        $nestedFilter->setQuery( new \Elastica\Query\Range('beginDate',
            array(
                'gte' => \Elastica\Util::convertDate((new \DateTime())->getTimestamp()),
            )
        ) );

        // Create a bool filter to put everything together
        $boolFilter = new \Elastica\Filter\Bool();
        $boolFilter->addMust($productTypeFilter);
        $boolFilter->addMust($nestedFilter);

        // Show only products

        // Filter type
        if ( $categorySearch->getIsProduct() || $categorySearch->getIsInfoEvent()) {
            // Create OR filter to put together the types
            $typeOrFilter = new \Elastica\Filter\BoolOr();

            // Filter products
            if ( $categorySearch->getIsProduct() ) {
                $productAndFilter =  new \Elastica\Filter\BoolAnd();
                $productAndFilter->addFilter($productTypeFilter);

                $infoFilter = new \Elastica\Filter\Term(array('infoVa' => false));
                $productAndFilter->addFilter($infoFilter);

                $typeOrFilter->addFilter($productAndFilter);
            }

            // Filter info events if isProduct is not selected
            if ( $categorySearch->getIsInfoEvent() ) {
                $productAndFilter =  new \Elastica\Filter\BoolAnd();
                $productAndFilter->addFilter($productTypeFilter);

                $infoFilter = new \Elastica\Filter\Term(array('infoVa' => true));
                $productAndFilter->addFilter($infoFilter);

                $typeOrFilter->addFilter($productAndFilter);
            }

            $boolFilter->addMust($typeOrFilter);
        }

        // Filter product type
        if ( $categorySearch->getProductType() ) {
            $productTypeFilter = new \Elastica\Filter\Nested();
            $productTypeFilter->setPath('productType');
            $productTypeFilter->setFilter( new \Elastica\Filter\Term(array('productType._id' => $categorySearch->getProductType()->getId())) );
            $boolFilter->addMust($productTypeFilter);
        }

        // Filter day time
        if ( $categorySearch->getDayTime() ) {
            $dayTimeFilter = new \Elastica\Filter\Nested();
            $dayTimeFilter->setPath('courses');
            $dayTimeFilter->setFilter( new \Elastica\Filter\Term(array('courses.dayTimes' => $categorySearch->getDayTime())) );
            $boolFilter->addMust($dayTimeFilter);
        }

        // Filter categories
        $categoryIds = array();
        if ( $categorySearch->getSubcategories() instanceof \Traversable ) {
            foreach ($categorySearch->getSubcategories() as $category) {
                if (is_object($category)) $categoryIds[] = $category->getId();
                else $categoryIds[] = $category;
            }
        }

        if (empty($categoryIds)) {
            $categoryIds[] = $currentCategory->getId();
            foreach ($currentCategory->getChildren() as $child) {
                $categoryIds[] = $child->getId();
            }
        }

        // Filter category
        {
            $categoryFilter = new \Elastica\Filter\BoolOr();

            $mainCategoryFilter = new \Elastica\Filter\Nested();
            $mainCategoryFilter->setPath('category');
            $mainCategoryFilter->setFilter( new \Elastica\Filter\Terms('category._id', array($categoryIds)) );

            $subCategoryFilter = new \Elastica\Filter\Nested();
            $subCategoryFilter->setPath('subcategory');
            $subCategoryFilter->setFilter( new \Elastica\Filter\Terms('subcategory._id', array($categoryIds)) );

            $additionalCategoryFilter = new \Elastica\Filter\Nested();
            $additionalCategoryFilter->setPath('additionalCategories');
            $additionalCategoryFilter->setFilter( new \Elastica\Filter\Terms('additionalCategories._id', array($categoryIds)) );

            $categoryFilter->addFilter($mainCategoryFilter);
            $categoryFilter->addFilter($subCategoryFilter);
            $categoryFilter->addFilter($additionalCategoryFilter);
            $boolFilter->addMust($categoryFilter);
        }

        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolFilter);

        $query = \Elastica\Query::create($filtered);
        $sort = $categorySearch->getSort();
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
            ->setMaxPerPage($categorySearch->getPerPage())
            ->setCurrentPage($categorySearch->getPage())
        ;

        return $paginated;
    }
}
