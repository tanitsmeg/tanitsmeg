<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Entity\Testimonial;

class TestimonialController extends Controller {

    /**
     * @Route("/{categorySlug}/testimonial/{slug}/", defaults={"slug" = 0, "subcategorySlug" = null}, name="testimonial_view")
     * @Route("/{categorySlug}/{subcategorySlug}/testimonial/{slug}/", defaults={"slug" = 0}, name="testimonial_view_with_subcategory")
     */
    public function viewAction($categorySlug, $subcategorySlug, $slug) {
        try {
            $trainer = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Testimonial')->findOneBy(array('slug' => $slug));
        }
        catch (NoResultException $e) {
            throw $this->createNotFoundException("no news to display");
        }
        
        $jsParams = array(
        );

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('testimonial', null, null);
        
        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $trainer,
            'blocks' => $blocks,
        );

        return $this->render('DNTMBundle:Testimonial:view.html.twig', $retParams);
    }
    
    /**
     * @Route("/{categorySlug}/testimonial/", defaults={"slug" = 0, "subcategorySlug" = null}, name="testimonial_overview")
     * @Route("/{categorySlug}/{subcategorySlug}/testimonial/", defaults={"slug" = 0}, name="testimonial_overview_with_subcategory")
     */
    public function overviewAction($categorySlug, $subcategorySlug) {
        $categoryList = null;
        $resultList = null;
        
        $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));

        // todo: finish it
        if ($category != null) {
            if ($subcategorySlug == null) {
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('isMain' => true));
                // todo: search news in subcategory, additional categories
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Testimonial')->findBy(array('category' => $category->getId()));
            } else {
                $subcategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Testimonial')->findBy(array('category' => $category->getId()));
                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => $category->getId()));
            }
        }

        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('articleOverview', $cmsObject);

        $retParams = array(
            'resultList' => $resultList,
            'categoryList' => $categoryList,
            'blocks' => $blocks,
        );

        return $this->render('DNTMBundle:Testimonial:overview.html.twig', $retParams);
    }

}
