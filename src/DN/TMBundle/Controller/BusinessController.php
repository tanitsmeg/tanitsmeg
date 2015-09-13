<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DN\TMBundle\Entity\CMSObject;

class BusinessController extends Controller {

    /**
     * @Route("/business/", name="business_home_view")
     */
    public function homeAction() {
        $cmsObject = new CMSObject();
        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('business', $cmsObject);
        
        $slideShowData = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PageBlock')->findBy(array('type' => 'business_slideshow'));

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'blocks' => $blocks,
            'slideShowData' => $slideShowData,
        );

        return $this->render('DNTMBundle:Business:home.html.twig', $retParams);
    }

    /**
     * @Route("/business/{slug}/", name="business_view")
     */
    public function viewAction($slug, Request $request) {
        $pagePath = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PagePath')->findOneBy(array('path' => $slug, 'area' => 'business'));

        $object = null;
        if ($pagePath != null) {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomPage')->findOneBy(array('id' => $pagePath->getAction()));
        }

        if ($object == null) {
            throw $this->createNotFoundException("no page to display (business)");
        }

        $slideShowData = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PageBlock')->findBy(array('type' => 'business_slideshow'));

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('business', $object);

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'blocks' => $blocks,
            'slideShowData' => $slideShowData,
        );

        return $this->render('DNTMBundle:Business:view.html.twig', $retParams);
    }

}
