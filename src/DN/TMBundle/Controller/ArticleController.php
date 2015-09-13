<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Entity\Article;

class ArticleController extends Controller {

    /**
     * @Route("/{categorySlug}/artikel/{slug}/", defaults={"slug" = 0, "subcategorySlug" = null}, name="article_view")
     * @Route("/{categorySlug}/{subcategorySlug}/artikel/{slug}/", defaults={"slug" = 0}, name="article_view_with_subcategory")
     */
    public function viewAction($categorySlug, $subcategorySlug, $slug) {
        try {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Article')->findBySlugAndCategories($slug, $categorySlug, $subcategorySlug);
        }
        catch (NoResultException $e) {
            throw $this->createNotFoundException("no article to display");
        }
        
        $jsParams = array(
        );

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('article', $object);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('article', $object);
        
        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:Article:view.html.twig', $retParams);
    }

    /**
     * @Route("/{categorySlug}/artikel/", defaults={"subcategorySlug" = null}, name="article_overview")
     * @Route("/{categorySlug}/{subcategorySlug}/artikel/", name="article_overview_with_subcategory")
     */
    public function overviewAction($categorySlug, $subcategorySlug) {
        $categoryList = null;
        $resultList = null;
        
        $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));
        
        // todo: finish it
        if ($category != null) {
            if ($subcategorySlug == null) {
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('isMain' => true));
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Article')->findBy(array('category' => $category->getId()));
//                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Article')->findForOverviewPage($category);
            } else {
                $subcategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Article')->findBy(array('subcategory' => $subcategory->getId()));
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => $category->getId()));
            }
        }

        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('articleOverview', $cmsObject);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('articleOverview', $cmsObject);

        $retParams = array(
            'resultList' => $resultList,
            'categoryList' => $categoryList,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:Article:overview.html.twig', $retParams);
    }

}
