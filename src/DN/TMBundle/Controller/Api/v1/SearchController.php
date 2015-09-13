<?php

namespace DN\TMBundle\Controller\Api\v1;

use FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\FOSRestController,
    Nelmio\ApiDocBundle\Annotation\ApiDoc,
    Symfony\Component\HttpFoundation\Request,
    FOS\RestBundle\Controller\Annotations\Options,
    FOS\RestBundle\Controller\Annotations\Get;
use Doctrine\ORM\NoResultException;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use DN\TMBundle\Model\SiteSearch,
    DN\TMBundle\Model\CategorySearch;

class SearchController extends FOSRestController {
    /**
     * @View()
     * @ApiDoc()
     */
    public function optionsSearchAction(){}

    /**
     * @View()
     * @ApiDoc()
     * @Options("/category/{categorySlug}", name="_category", defaults={"parentCategorySlug" = null})
     * @Options("/category/{parentCategorySlug}/{categorySlug}", name="_subcategory")
     */
    public function optionsCategoryAction($parentCategorySlug, $categorySlug){}

    /**
     * @View()
     * @ApiDoc()
     */
    public function getSearchAction(Request $request) {
        $siteSearch = new SiteSearch();

        $searchForm = $this->get('form.factory')
            ->createNamed(
                '',
                'advanced_search_type',
                $siteSearch,
                array(
                    'action' => $this->generateUrl('DNTMBundle_Search'),
                    'method' => 'GET',
                )
            );

        $searchForm->handleRequest($request);
        $siteSearch = $searchForm->getData();

        $pager = $this->get('dn.tm.search.site')->search($siteSearch);
        /** @var $pager \Pagerfanta\Pagerfanta */

        return $pager->getCurrentPageResults();
    }

    /**
     * @View()
     * @ApiDoc()
     * @Get("/category/{categorySlug}", name="_category", defaults={"parentCategorySlug" = null})
     * @Get("/category/{parentCategorySlug}/{categorySlug}", name="_subcategory")
     */
    public function getCategoryAction(Request $request, $categorySlug, $parentCategorySlug) {
        try {
            //TODO: Move to manager
            $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->getCategoryBySlug($categorySlug, $parentCategorySlug);

            $categorySearch = new CategorySearch();

            $searchForm = $this->get('form.factory')
                ->createNamed(
                    '',
                    'category_search_type',
                    $categorySearch,
                    array(
                        'method' => 'GET',
                        'subcategories' => $category->getChildren(),
                    )
                );

            $searchForm->handleRequest($request);
            $categorySearch = $searchForm->getData();

            $pager = $this->get('dn.tm.search.category')->search($category, $categorySearch);
            /** @var $pager \Pagerfanta\Pagerfanta */

            return $pager->getCurrentPageResults();

        }
        catch (NoResultException $e) {
            throw new NotFoundHttpException($e->getMessage(), $e);
        }
    }

}
