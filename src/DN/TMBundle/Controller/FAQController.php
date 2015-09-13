<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DN\TMBundle\Entity\CMSObject;

class FAQController extends Controller {

    /**
     * @Route("/service/faq/", name="faq_view")
     */
    public function viewAction() {
        // todo: joinolva
        $faqCategories = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:FAQCategory')->findAll();
        $faqs = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:FAQ')->findAll();

        $jsParams = array(
        );

        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('faq', $cmsObject);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('faq', $cmsObject);
        
        $retParams = array(
            'faqs' => $faqs,
            'faqCategories' => $faqCategories,
            'jsParams' => $jsParams,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:FAQ:view.html.twig', $retParams);
    }

}
