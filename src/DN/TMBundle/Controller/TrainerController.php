<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\CMSObject;
use DN\TMBundle\Entity\Trainer;

class TrainerController extends Controller {

    /**
     * @Route("/{categorySlug}/trainer/", defaults={"slug" = null, "subcategorySlug" = null}, name="trainer_overview")
     * @Route("/{categorySlug}/{subcategorySlug}/trainer/", defaults={"slug" = null}, name="trainer_overview_with_subcategory")
     * @Route("/{categorySlug}/trainer/{slug}/", defaults={"slug" = null, "subcategorySlug" = null}, name="trainer_view")
     * @Route("/{categorySlug}/{subcategorySlug}/trainer/{slug}/", defaults={"slug" = null}, name="trainer_view_with_subcategory")
     */
    public function viewAction($categorySlug, $subcategorySlug, $slug) {
        $object = null;
        
        if ($slug != null) {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findBySlugAndCategories($slug, $categorySlug, $subcategorySlug);
        }
        
//        if ($object == null) {
//            try {
//                $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findOneBy(array());
//            } catch (NoResultException $e) {
//                throw $this->createNotFoundException("no trainers found");
//            }
//        }

        $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));
//        $subcategory = null;
        
        if ($category != null) {
            $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('isMain' => true));
            $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findBy(array('category' => $category->getId()));
//            if ($subcategorySlug == null) {
//            } else {
//                $subcategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
//                if ($subcategory != null) {
//                    $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findBy(array('category' => $category->getId(), 'subcategory' => $subcategory->getId()));
//                    $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => $category->getId()));
//                } else {
//                    throw $this->createNotFoundException("no subcategory found");
//                }
//            }
        } else {
            throw $this->createNotFoundException("no category found");
        }

        $jsParams = array(
        );

        $retParams = array(
            'resultList' => $resultList,
            'categoryList' => $categoryList,
            'category' => $category,
//            'subcategory' => $subcategory,
            'jsParams' => $jsParams,
            'object' => $object,
        );

        return $this->render('DNTMBundle:Trainer:view.html.twig', $retParams);
    }

//    /**
//     * @Route("/{categorySlug}/trainer/", defaults={"slug" = 0, "subcategorySlug" = null}, name="trainer_overview")
//     * @Route("/{categorySlug}/{subcategorySlug}/trainer/", defaults={"slug" = 0}, name="trainer_overview_with_subcategory")
//     */
//    public function overviewAction($categorySlug, $subcategorySlug) {
//        $categoryList = null;
//        $resultList = null;
//
//        $category = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $categorySlug));
//
//        // todo: finish it
//        if ($category != null) {
//            if ($subcategorySlug == null) {
//                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('isMain' => true));
//                //            $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => null));
//                // todo: search news in subcategory, additional categories
//                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findBy(array('category' => $category->getId()));
//            } else {
//                $subcategory = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findOneBy(array('slug' => $subcategorySlug));
//                $resultList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Trainer')->findBy(array('category' => $category->getId()));
//                $categoryList = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Category')->findBy(array('parent' => $category->getId()));
//            }
//        }
//
//        $cmsObject = new CMSObject();
//        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('articleOverview', $cmsObject);
//
//        $retParams = array(
//            'resultList' => $resultList,
//            'categoryList' => $categoryList,
//            'blocks' => $blocks,
//        );
//
//        return $this->render('DNTMBundle:Trainer:overview.html.twig', $retParams);
//    }

}
