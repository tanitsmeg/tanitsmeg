<?php

namespace DN\TMBundle\Entity;

use DateTime;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use DN\TMBundle\Entity\BaseRepository;

class UserRepository extends BaseRepository {

    /**
     * saving after signup
     * 
     * @param type $object
     * @return boolean
     */
    public function saveUser($object) {        
        if ($object->getId() == null) {
            $object->setCreated(new \DateTime('now'));
            $object->setActive(true);
        }

        $this->getEntityManager()->merge($object);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * saving after teacher_signup
     *
     * @param type $object
     * @return boolean
     */
    public function saveTeacher($object) {
        if ($object->getId() == null) {
            $object->setCreated(new \DateTime('now'));
            $object->setActive(true);
            $object->setCategory('t');
        }

        $this->getEntityManager()->merge($object);
        $this->getEntityManager()->flush();

        return true;
    }

    /**
     * saving after data edit
     * 
     * @param type $object
     * @return boolean
     */
    public function saveUserData($object) {
//        $object->setCreated(new \DateTime('now'));
//        $object->setActive(true);

        $this->getEntityManager()->merge($object);
        $this->getEntityManager()->flush();

        return true;
    }

    public function getUserData($object) {
        if ($object->getId() == null) {
            $object->setCreated(new \DateTime('now'));
            $object->setActive(true);
        }

        $this->getEntityManager()->merge($object);
        $this->getEntityManager()->flush();

        return true;
    }

}
