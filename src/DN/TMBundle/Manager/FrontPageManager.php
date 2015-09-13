<?php

namespace DN\TMBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class FrontPageManager {

    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function  getLatest() {
        return $this->em->getRepository('DNTMBundle:FrontPage')->findLatest();
    }
}
