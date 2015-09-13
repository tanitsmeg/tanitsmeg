<?php

namespace DN\TMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\NoResultException;

use DN\TMBundle\Entity\Product;
use DN\TMBundle\Entity\Course;
use DN\TMBundle\Entity\Category;

class AaaaaController extends Controller {

    /**
     * @Route("/aaaaa/", name="aaaaa")
     */
    public function viewAction() {
        $form = $this->get('form.factory')
            ->createNamed(
                '',
                'aaaaa_type'
            );

        return $this->render('DNTMBundle::aaaaa.html.twig', array('form' => $form->createView()));
    }
    
}
