<?php

namespace DN\TMBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class CustomFormManager {

    private $em;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container) {
        $this->em = $entityManager;
        $this->container = $container;
    }

    public function getPostedForm($request) {
        $ret = null;

        $formTypes = array('newsletter', 'contact');

        $i = 0;
        while ($i < count($formTypes) && $request->request->get($formTypes[$i]) == null) {
            $i++;
        }

        if ($i < count($formTypes)) {
            $ret = array(
                'form' => $request->request->get($formTypes[$i]),
                'type' => $formTypes[$i],
            );
        }

        return $ret;
    }

}
