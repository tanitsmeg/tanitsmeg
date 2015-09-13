<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;

use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;

class CustomPageController extends Controller {

    /**
     * @Route("/{slug}/", name="custom_page_view")
     */
    public function viewAction($slug) {
        // todo: handle if there are more pages with the same slug under different routes
        // todo: trim slug (?)
        $pagePath = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PagePath')->findOneBy(array('actionType' => 'customPage', 'path' => $slug, 'area' => 'privat'));

        $object = null;
        if ($pagePath != null) {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomPage')->findOneBy(array('id' => $pagePath->getAction()));
        }

        if ($object == null) {
            throw $this->createNotFoundException("no page to display");
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
            'pageType' => 'customPage',
        );

        return $this->render('DNTMBundle:CustomPage:view.html.twig', $retParams);
    }

}
