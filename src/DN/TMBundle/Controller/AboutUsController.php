<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;

class AboutUsController extends Controller {

    /**
     * @Route("/ueber-uns/", name="about_us_home_view", defaults={"slug" = null})
     * @Route("/ueber-uns/{slug}/", name="about_us_view")
     */
    public function viewAction($slug, Request $request) {
        // todo: handle if there are more pages with the same slug under different routes
        $pagePath = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PagePath')->findOneBy(array('path' => $slug, 'area' => 'ueber-uns'));

        $object = null;
        if ($pagePath != null) {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomPage')->findOneBy(array('id' => $pagePath->getAction()));
        }

        if ($object == null) {
            throw $this->createNotFoundException("no page to display (about us)");
        }

        $blocks = $this->get('dn.tm.manager.page_block')->getRightSideBlocks('customPage', $object);
        $blockFilters = $this->get('dn.tm.manager.page_block')->getBlockFiltersFromObject('customPage', $object);

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
            'blocks' => $blocks,
            'blockFilters' => $blockFilters,
        );

        return $this->render('DNTMBundle:AboutUs:view.html.twig', $retParams);
    }

}
