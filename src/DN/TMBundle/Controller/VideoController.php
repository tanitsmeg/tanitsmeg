<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Entity\Video;

class VideoController extends Controller {

    /**
     * @Route("/{categorySlug}/video/{slug}/", defaults={"slug" = 0, "subcategorySlug" = null}, name="video_view")
     * @Route("/{categorySlug}/{subcategorySlug}/video/{slug}/", defaults={"slug" = 0}, name="video_view_with_subcategory")
     */
    public function viewAction($categorySlug, $subcategorySlug, $slug) {
        try {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Video')->findOneBy(array('slug' => $slug));
        }
        catch (NoResultException $e) {
            throw $this->createNotFoundException("no news to display");
        }
        
        $jsParams = array(
        );

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('video', $object);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('video', $object);

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:Video:view.html.twig', $retParams);
    }

    /**
     * @Route("/{categorySlug}/video/", defaults={"slug" = 0, "subcategorySlug" = null}, name="video_overview")
     * @Route("/{categorySlug}/{subcategorySlug}/video/", defaults={"slug" = 0}, name="video_overview_with_subcategory")
     */
    public function overviewAction($categorySlug, $subcategorySlug) {
        $categoryList = null;
        $resultList = null;

        $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));

        // todo: finish it
        if ($category != null) {
            if ($subcategorySlug == null) {
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('isMain' => true));
    //            $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => null));
                // todo: search news in subcategory, additional categories
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Video')->findBy(array('category' => $category->getId()));
            } else {
                $subcategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Video')->findBy(array('category' => $category->getId()));
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => $category->getId()));
            }
        }

        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('videoOverview', $cmsObject);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('videoOverview', $cmsObject);

        $retParams = array(
            'resultList' => $resultList,
            'categoryList' => $categoryList,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:Video:overview.html.twig', $retParams);
    }


}
