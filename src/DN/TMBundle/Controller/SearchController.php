<?php

namespace DN\TMBundle\Controller;

use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Model\SiteSearch,
    DN\TMBundle\Model\CategorySearch;

class SearchController extends Controller {

    /**
     * @Route("/suche/", name="DNTMBundle_Search")
     */
    public function searchAction(Request $request) {
        //TODO: Move to manager
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

        $cmsObject = new CMSObject();

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('productSearch', $cmsObject);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('productSearch', $cmsObject);

        $categorySlug = null;
        if ($siteSearch->getCategory() != null) {
            $cmsObject->setCategory($siteSearch->getCategory());
            $categorySlug = $siteSearch->getCategory()->getSlug();
        }

        $ajax = '';
        if ($request->isXmlHttpRequest()) $ajax = '/Ajax';
        return $this->render('DNTMBundle:Search'.$ajax.':view.html.twig',array(
            'text' => $siteSearch->getText(),
            'pager' => $pager,
            'searchForm' => $searchForm->createView(),
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
            'categorySlug' => $categorySlug,
        ));
    }

    /**
     * @Route("/{categorySlug}/", name="DNTMBundle_Category", defaults={"parentCategorySlug" = null})
     * @Route("/{parentCategorySlug}/{categorySlug}/", name="DNTMBundle_Subcategory")
     */
    public function categoryAction(Request $request, $categorySlug, $parentCategorySlug) {
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

            $cmsObject = new CMSObject();

            $categorySlugParam = null;
            $categoryImg = null;

            if ($parentCategorySlug != null) {
                $categoryImg = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $parentCategorySlug));
            } else
            if ($categorySlug != null) {
                $categoryImg = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));
            }
            if ($categoryImg != null) {
                $categorySlugParam = $categoryImg->getSlug();
                $cmsObject->setCategory($categoryImg);
            }
            
            $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('categoryOverview', $cmsObject);
            $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('categoryOverview', $cmsObject);

            $ajax = '';
            if ($request->isXmlHttpRequest()) $ajax = '/Ajax';
            return $this->render('DNTMBundle:Search'.$ajax.':category.html.twig',array(
                'category' => $category,
                'pager' => $pager,
                'searchForm' => $searchForm->createView(),
                'blocks' => $blocks,
                'blockFilters' => $blockFilters,
                'categorySlug' => $categorySlugParam,
            ));

        }
        catch (NoResultException $e) { // HACK: If an error happens forward to the CustomPageController with the url
            // For a more clean solution check the RoutingBundle (http://symfony.com/doc/current/cmf/bundles/routing/index.html)
            return $this->forward('DNTMBundle:CustomPage:view', array(
                'slug' => ltrim($this->get('request')->getPathInfo(), '/'),
            ));
        }
    }

}
