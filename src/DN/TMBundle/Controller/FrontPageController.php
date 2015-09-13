<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DN\TMBundle\Entity\CMSObject;

use DN\TMBundle\Model\SiteSearch;

class FrontPageController extends Controller {

    /**
     * @Route("/", name="front_page")
     */
    public function indexAction() {
//        $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:Course')->findOneBy(array('slug' => $slug));
//
//        if ($object == null) {
//            throw $this->createNotFoundException("no courses to display");
//        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
//            'object' => $object,
        );

        return $this->render('DNTMBundle:FrontPage:view.html.twig', $retParams);
    }

}
