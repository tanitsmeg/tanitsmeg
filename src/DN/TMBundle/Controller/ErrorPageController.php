<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ErrorPageController extends Controller {

    /**
     * @Route("/error/", name="error_view")
     */
    public function viewAction(Request $request) {
        // todo: handle if there are more pages with the same slug under different routes
        $pagePath = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:PagePath')->findOneBy(array('path' => 'error/'));

        $object = null;
        if ($pagePath != null) {
            $object = $this->getDoctrine()->getManager()->getRepository('DNTMBundle:CustomPage')->findOneBy(array('id' => $pagePath->getAction()));
        }

        $jsParams = array(
        );

        $retParams = array(
            'jsParams' => $jsParams,
            'object' => $object,
        );

        return $this->render('DNTMBundle:Error:view.html.twig', $retParams);
    }
    
}
