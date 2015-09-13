<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;

class CommonController extends Controller {

    public function headerViewAction(Request $request) {
        $session = $request->getSession();
        $session->start();
        $loggedIdUser = $session->get('loggedInUser');

        $jsParams = array(
            'userSignupAjaxUrl' => $this->generateUrl('user_signup_ajax'),
        );
        
        $retParams = array(
            'userSignupAjaxUrl' => $this->generateUrl('user_signup_ajax'),
            'jsParams' => $jsParams,
            'loggedIdUser' => $loggedIdUser,
        );

        return $this->render('DNTMBundle:Common:header.html.twig', $retParams);
    }

    public function footerViewAction() {
        $retParams = array(
        );

        return $this->render('DNTMBundle:Common:footer.html.twig', $retParams);
    }

    /**
     * @Route("/terms/", name="terms_view")
     */
    public function termsViewAction() {
        $retParams = array(
        );

        return $this->render('DNTMBundle:Common:terms.html.twig', $retParams);
    }

    /**
     * @Route("/info/", name="info_view")
     */
    public function infoViewAction() {
        $retParams = array(
        );

        return $this->render('DNTMBundle:Common:info.html.twig', $retParams);
    }

}
